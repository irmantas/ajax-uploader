(function($){
	jQuery.event.props.push('dataTransfer');
	$.fn.extend({
		ajaxUpload: function (options) {
			var defaults = {
				name: 'file',
				action: '',
				params: {},
				strings: {
					buttonTitle: 'Upload File',
					dragDropZone: 'Drag files here',
					error: 'Error',
					success: 'Success',
				},
				debug: false,
				multiple: true,
				onSubmit: function () {},
				onComplete: function () {},
				buttonTemplate: '<div id="is-au-button">{buttonTitle}</div>',
				dragDropZoneTemplate: '<div id="is-au-dgzone">{dragDropZone}</div>'
			};
			
			var opt = $.extend(defaults, options);
			
			var uploadButton = {
				createButton: function () {
					var button = $(opt.buttonTemplate.replace('{buttonTitle}', opt.strings.buttonTitle));
					button.append(this.createInput());
					return button;
				},
				createInput: function () {
					var input = $('<input />');
					if (opt.multiple) {
						input.attr('multiple', 'multiple');
					}
					
					input.attr({name: opt.name, type:'file'});
					input.css({
						position:'absolute',
						right: 0,
						top: 0,
						fontSize: '118px',
						margin:0,
						padding:0,
						cursor:'pointer',
						opacity:0,
						zIndex:1
					});
					
					return input;
				},
				
				createDragDropZone : function () {
					var zone = $(opt.dragDropZoneTemplate.replace('{dragDropZone}', opt.strings.dragDropZone));
					zone.hide();
					
					$(document).bind('dragenter', function(e){
							zone.show();
							e.stopPropagation();
							e.preventDefault();
						})
						.bind('dragleave', function(e){
							e.stopPropagation();
							e.preventDefault();
							var elem = $(document.elementFromPoint(e.clientX, e.clientY));
							if (elem.length == 0 || elem.is('html')) {
								zone.hide()
							}
						})
						.bind('dragover', function(e){
							e.stopPropagation();
							e.preventDefault();
						})
						.bind('drop', function(e){
							e.stopPropagation();
							e.preventDefault();
							zone.hide();
						});
					
					zone.bind('dragover', function (e){
						e.stopPropagation();
						e.preventDefault();
					})
					.bind('dragleave', function (e){
						e.stopPropagation();
						e.preventDefault();
						zone.removeClass('is-au-over');
					})
					.bind('dragenter', function (e){
						e.stopPropagation();
						e.preventDefault();
						zone.addClass('is-au-over');
						return;
					})
					.bind('drop', function (e){
						e.stopPropagation();
						e.preventDefault();
						zone.hide();
						zone.removeClass('is-au-over');
						var handler = uploadHandler.upload(e.dataTransfer.files);
						return;
					});
					
					return zone;
				}
			};
			
			var uploadHandler = {
				upload: function (fileList) {
					var iframe = this.createIfrme((new Date).getTime());
					var form = this.createForm(iframe, opt.params);
					var fileList = $(fileList);
					var self = this;
					fileList.each(function(){
						self.uploadFile(this, form);
					});
				},
				uploadFile: function (file, form) {
					var elem = $('<input type="file" name="'+opt.name+'">');
					console.log(file);
					//elem.val(file);
					form.append(file);
					form.submit();
					//form.remove(elem);
				},
				createIfrme: function (id) {
					var iframe = $('<iframe src="javascript:false" name="'+id+'" id="'+id+'" />');
					iframe.hide();
					$('body').append(iframe);
					return iframe;
				},
				createForm: function(iframe, params) {
					var form = $('<form method="post" enctype="multipart/form-data"></form>');
					form.attr({
						action: opt.action + $.param(params),
						target: iframe.attr('name')
					});
					form.hide();
					$('body').append(form);
					return form;
				}
			};
			
			return this.each(function(){
				var e = $(this);
				e.html(uploadButton.createButton());
				e.append(uploadButton.createDragDropZone());
			});
		}
	});
})(jQuery);