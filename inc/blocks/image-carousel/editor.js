/**
 * "Image Carousel" block editor UI — plain JS, no build step (no JSX,
 * no wp-scripts/webpack). Uses the wp.* globals WordPress already
 * enqueues for every block editor script.
 *
 * Dynamic block: save() returns null on purpose. Only the `images`
 * attribute is persisted (as JSON in the block comment delimiter) —
 * markup comes entirely from render_callback in block.php.
 */
(function (blocks, element, blockEditor, components, i18n) {
	var el = element.createElement;
	var Fragment = element.Fragment;
	var useBlockProps = blockEditor.useBlockProps;
	var InspectorControls = blockEditor.InspectorControls;
	var MediaUpload = blockEditor.MediaUpload;
	var MediaUploadCheck = blockEditor.MediaUploadCheck;
	var Button = components.Button;
	var Placeholder = components.Placeholder;
	var PanelBody = components.PanelBody;
	var ToggleControl = components.ToggleControl;
	var __ = i18n.__;

	function toImageAttribute(media) {
		return { id: media.id, url: media.url, alt: media.alt || '' };
	}

	blocks.registerBlockType('chcapital/image-carousel', {
		apiVersion: 2,

		edit: function (props) {
			var attributes = props.attributes;
			var setAttributes = props.setAttributes;
			var images = attributes.images || [];
			var blockProps = useBlockProps({ className: 'chcapital-image-carousel-editor' });

			function onSelectImages(media) {
				var newImages = media.map(toImageAttribute);
				var existingIds = images.map(function (image) {
					return image.id;
				});
				var appended = newImages.filter(function (image) {
					return existingIds.indexOf(image.id) === -1;
				});

				setAttributes({ images: images.concat(appended) });
			}

			function removeImage(index) {
				var next = images.slice();
				next.splice(index, 1);
				setAttributes({ images: next });
			}

			function moveImage(index, direction) {
				var target = index + direction;
				if (target < 0 || target >= images.length) {
					return;
				}

				var next = images.slice();
				var moved = next[index];
				next[index] = next[target];
				next[target] = moved;
				setAttributes({ images: next });
			}

			var inspectorControls = el(
				InspectorControls,
				{},
				el(
					PanelBody,
					{ title: __('Carousel settings', 'taw-theme'), initialOpen: true },
					el(ToggleControl, {
						label: __('Auto-start (autoplay)', 'taw-theme'),
						help: __('Advances slides automatically. Ignored for visitors with reduced-motion enabled.', 'taw-theme'),
						checked: !!attributes.autoplay,
						onChange: function (value) {
							setAttributes({ autoplay: value });
						},
					}),
					el(ToggleControl, {
						label: __('Allow drag to scroll', 'taw-theme'),
						help: __('Lets visitors click and drag with a mouse to scroll the carousel.', 'taw-theme'),
						checked: attributes.drag !== false,
						onChange: function (value) {
							setAttributes({ drag: value });
						},
					})
				)
			);

			var pickerButton = el(MediaUploadCheck, {},
				el(MediaUpload, {
					multiple: true,
					gallery: true,
					addToGallery: images.length > 0,
					allowedTypes: ['image'],
					value: images.map(function (image) {
						return image.id;
					}),
					onSelect: onSelectImages,
					render: function (openerProps) {
						return el(
							Button,
							{
								variant: images.length ? 'secondary' : 'primary',
								onClick: openerProps.open,
							},
							images.length
								? __('Add images', 'taw-theme')
								: __('Select images', 'taw-theme')
						);
					},
				})
			);

			if (!images.length) {
				return el(
					Fragment,
					{},
					inspectorControls,
					el(
						'div',
						blockProps,
						el(
							Placeholder,
							{
								icon: 'images-alt2',
								label: __('Image Carousel', 'taw-theme'),
								instructions: __(
									'Select the images this carousel should show, in order.',
									'taw-theme'
								),
							},
							pickerButton
						)
					)
				);
			}

			var thumbnails = images.map(function (image, index) {
				return el(
					'div',
					{ className: 'chcapital-image-carousel-editor__item', key: image.id + '-' + index },
					el('img', { src: image.url, alt: image.alt }),
					el(
						'div',
						{ className: 'chcapital-image-carousel-editor__item-controls' },
						el(Button, {
							icon: 'arrow-left-alt2',
							label: __('Move left', 'taw-theme'),
							isSmall: true,
							disabled: index === 0,
							onClick: function () {
								moveImage(index, -1);
							},
						}),
						el(Button, {
							icon: 'no-alt',
							label: __('Remove image', 'taw-theme'),
							isSmall: true,
							isDestructive: true,
							onClick: function () {
								removeImage(index);
							},
						}),
						el(Button, {
							icon: 'arrow-right-alt2',
							label: __('Move right', 'taw-theme'),
							isSmall: true,
							disabled: index === images.length - 1,
							onClick: function () {
								moveImage(index, 1);
							},
						})
					)
				);
			});

			return el(
				Fragment,
				{},
				inspectorControls,
				el(
					'div',
					blockProps,
					el('div', { className: 'chcapital-image-carousel-editor__grid' }, thumbnails),
					pickerButton
				)
			);
		},

		save: function () {
			return null;
		},
	});
})(
	window.wp.blocks,
	window.wp.element,
	window.wp.blockEditor,
	window.wp.components,
	window.wp.i18n
);
