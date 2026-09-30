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

	// Inline SVG icons (same paths as @wordpress/icons) rather than Dashicon
	// slugs: the post editor canvas is an iframe that doesn't load the
	// Dashicons font, so slug-based icons render as blank buttons there.
	function svgIcon(path) {
		return el(
			'svg',
			{ xmlns: 'http://www.w3.org/2000/svg', viewBox: '0 0 24 24', width: 24, height: 24, 'aria-hidden': true, focusable: false },
			el('path', { d: path })
		);
	}

	var ICON_LEFT = svgIcon('M14.6 7l-1.2-1L8 12l5.4 6 1.2-1-4.6-5z');
	var ICON_RIGHT = svgIcon('M10.6 6L9.4 7l4.6 5-4.6 5 1.2 1 5.4-6z');
	var ICON_REMOVE = svgIcon('M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z');

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

			var dragState = element.useState(null);
			var dragIndex = dragState[0];
			var setDragIndex = dragState[1];
			var overState = element.useState(null);
			var overIndex = overState[0];
			var setOverIndex = overState[1];

			// The media modal opens in gallery mode pre-loaded with the current
			// images, so `media` is the complete list in the order (and with the
			// removals) the editor chose there — take it as-is rather than only
			// appending new ids, or any reordering done in the modal is lost.
			function onSelectImages(media) {
				var seen = {};
				var next = media.map(toImageAttribute).filter(function (image) {
					if (seen[image.id]) {
						return false;
					}
					seen[image.id] = true;
					return true;
				});

				setAttributes({ images: next });
			}

			function reorderImage(from, to) {
				if (from === null || to === null || from === to) {
					return;
				}

				var next = images.slice();
				var moved = next.splice(from, 1)[0];
				next.splice(to, 0, moved);
				setAttributes({ images: next });
			}

			// Drag-to-reorder uses pointer events, not native HTML5 drag and
			// drop: Gutenberg makes the whole block wrapper draggable (for
			// moving the block itself), so a native drag started on a thumbnail
			// becomes a drag of the entire block and the browser cancels the
			// pointer stream. onMouseDown's preventDefault stops that native
			// drag from ever starting (its dragstart fires on the wrapper, above
			// this grid, so it can't be cancelled from here), leaving plain
			// pointer events to drive the reorder.
			var pointerRef = element.useRef(null);

			function indexFromPoint(event) {
				var hit = event.currentTarget.ownerDocument.elementFromPoint(event.clientX, event.clientY);
				var item = hit && hit.closest('[data-carousel-index]');
				return item ? parseInt(item.getAttribute('data-carousel-index'), 10) : null;
			}

			function resetDrag() {
				pointerRef.current = null;
				setDragIndex(null);
				setOverIndex(null);
			}

			var gridHandlers = {
				onDragStart: function (event) {
					event.preventDefault();
					event.stopPropagation();
				},
				onMouseDown: function (event) {
					if (event.button === 0 && !event.target.closest('button') && event.target.closest('[data-carousel-index]')) {
						event.preventDefault();
					}
				},
				onPointerDown: function (event) {
					if (event.button !== 0 || event.target.closest('button')) {
						return;
					}
					var item = event.target.closest('[data-carousel-index]');
					if (!item) {
						return;
					}
					pointerRef.current = {
						id: event.pointerId,
						index: parseInt(item.getAttribute('data-carousel-index'), 10),
						x: event.clientX,
						y: event.clientY,
						active: false,
					};
				},
				onPointerMove: function (event) {
					var pointer = pointerRef.current;
					if (!pointer || pointer.id !== event.pointerId) {
						return;
					}
					if (!pointer.active) {
						// Small threshold so a plain click (e.g. to select the
						// block) never turns into a drag.
						if (Math.abs(event.clientX - pointer.x) + Math.abs(event.clientY - pointer.y) < 5) {
							return;
						}
						pointer.active = true;
						event.currentTarget.setPointerCapture(event.pointerId);
						setDragIndex(pointer.index);
					}
					event.preventDefault();
					setOverIndex(indexFromPoint(event));
				},
				onPointerUp: function (event) {
					var pointer = pointerRef.current;
					if (pointer && pointer.active && pointer.id === event.pointerId) {
						reorderImage(pointer.index, indexFromPoint(event));
					}
					resetDrag();
				},
				onPointerCancel: resetDrag,
			};

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
				var className = 'chcapital-image-carousel-editor__item';
				if (dragIndex === index) {
					className += ' is-dragging';
				}
				if (overIndex === index && dragIndex !== null && dragIndex !== index) {
					className += ' is-drop-target';
				}

				return el(
					'div',
					{
						className: className,
						key: image.id + '-' + index,
						'data-carousel-index': index,
						title: __('Drag to reorder', 'taw-theme'),
					},
					el('img', { src: image.url, alt: image.alt, draggable: false }),
					el(
						'div',
						{ className: 'chcapital-image-carousel-editor__item-controls' },
						el(Button, {
							icon: ICON_LEFT,
							label: __('Move left', 'taw-theme'),
							isSmall: true,
							disabled: index === 0,
							onClick: function () {
								moveImage(index, -1);
							},
						}),
						el(Button, {
							icon: ICON_REMOVE,
							label: __('Remove image', 'taw-theme'),
							isSmall: true,
							isDestructive: true,
							onClick: function () {
								removeImage(index);
							},
						}),
						el(Button, {
							icon: ICON_RIGHT,
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
					el(
						'p',
						{ className: 'chcapital-image-carousel-editor__hint' },
						__('Drag thumbnails (or use the arrows) to change the order.', 'taw-theme')
					),
					el('div', Object.assign({ className: 'chcapital-image-carousel-editor__grid' }, gridHandlers), thumbnails),
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
