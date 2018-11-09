function FileManager(){
    var self= this;
    var overplay = $(".loading-overplay");
    var type_select = "single";
    this.init= function(){
    	self.uploadFile();
    	self.loadFile(0);
    	self.deleteFile();
        self.optionFile();
        self.Dropbox();
        self.ImageEditor();
        self.watermark();
    };

    this.optionFile = function(){
    	$(document).on("click", ".select_multi_files", function(){
    		_that = $(this);
    		if($('input:checkbox').hasClass("checkItem")){
	    		if(!_that.hasClass("checked")){
			        $('input:checkbox').prop('checked',true);
			        _that.addClass('checked');
			    }else{
			        $('input:checkbox').prop('checked',false);
			        _that.removeClass('checked');        
			    }
			}
    		return false;
    	});

        $(document).on("click", ".file-manager-button-load-more", function(){
            _that = $(this);
            _page = _that.data("page");
            $(".file-manager-load-more").remove();
            self.loadFile(_page);
        });

        $(document).on("click", ".btnOpenFileManager", function(){
            var url = $(this).attr('href');
            $("#load_popup_modal_contant").remove();
            $('#mainModal').load(url,function(){
                $('#mainModal').modal('show');
                self.loadFile(0);
                if($(".scrollbar").length > 0){
                    $('.scrollbar').scrollbar({
                        "autoUpdate" : true
                    });
                }
            });
            return false;
        });

        $(document).on("click", ".file-manager-content .item input", function(){
            self.type_select = $(".image-manage").attr("data-type");
            self.type_select = ($(".image-manage").length == 0)?"multi":self.type_select;
            if(self.type_select != "multi" || self.type_select == undefined){
                $(this).parents(".item").siblings().find("input").prop('checked', false); 
            }
            $(".select_multi_files").removeClass("checked");
        });

        $(document).on("click", ".file-manager-btn-add-images", function(){
            _transfer = $(this).data("transfer");

            if($(".file-manager-content").length > 0){
                $(".file-manager-content .item").each(function(index, value){
                    _that  = $(this);
                    _image = _that.data("file");
                    if(_that.find("input").is(":checked")){
                        $(".file-manager-list-images .add-image").hide();
                        if(self.type_select != "multi"){
                            $(".file-manager-list-images .item").remove();
                        }

                        if(_transfer != undefined && _transfer != ""){
                            $("#"+_transfer).val(_image);
                        }
                        self.addFile(_image);
                    }
                });
            }
        });

        $(document).on("click", ".file-manager-list-images .item .close", function(){
            _that = $(this);
            _that.parents(".item").remove();
            if($(".file-manager-list-images .item").length <= 0){
                $(".file-manager-list-images .add-image").show();
            }
        });

        $(document).on("click", ".file-manager-change-type .item", function(){
            _that       = $(this);
            self.type_select = _that.data("type-image");
            $(".image-manage").attr("data-type", self.type_select);
            $(".file-manager-list-images .item").remove();
            $(".file-manager-list-images .add-image").show();
        });
    }

    this.Dropbox = function(){
        $(document).on("click", "#chooser-image", function(){
            _multi_files = true;
            _check_multi_files = $("#chooser-image").data("multi-files");
            if(_check_multi_files != undefined){
                _multi_files = _check_multi_files;
            }

            Dropbox.choose({
                linkType: "direct",
                multiselect: _multi_files,
                extensions: ['.jpg', '.png', '.mp4'],
                success: function (files) {
                    for (var i = 0; i < files.length; i++) {
                        self.saveFile(files[i].link, "");
                    }
                }
            });
        });
    };

    this.saveFile = function(_image){
        var _url = PATH + "file_manager/save_image";
        _data = $.param({token:token, image: _image});
        
        $('.file-manager-progress-bar').show().css( 'width', 50 + '%' );
        self.overplay();
        $.post(_url, _data, function(_result){
            self.hide_overplay();
            if(_result.status == "success"){
                self.addFile(_result.link);
                self.loadFile(0);
            }else{
                self.notify(_result.message, _result.status);
            }
            
            $('.file-manager-progress-bar').show().css( 'width', 100 + '%' );
            setTimeout(function(){
                $('.file-manager-progress-bar').fadeOut(100).css( 'width', 0 + '%' );
            }, 3000);
            
        }, 'json');
    };

    this.uploadFile = function(_id){
    	var url = PATH + "file_manager/upload_files";
        if(_id != undefined);
        _id = (_id == undefined)?"#fileupload":_id;

	    $(_id).fileupload({
	        url: url,
	        dataType: 'json',
	        formData: { token: token },
	        done: function (e, data) {
                self.hide_overplay();
                if(data.result.status == "success"){
                    self.addFile(data.result.link);
                }else{
                    self.notify(data.result.message, data.result.status);
                }
	        },
	        progressall: function (e, data) {
                self.overplay();
	            var progress = parseInt(data.loaded / data.total * 100, 10);
	            $('.file-manager-progress-bar').show().css( 'width', progress + '%' );
	        },
	        stop: function (e, data) {
				self.loadFile(0);	        	
	        	setTimeout(function(){
	        		$('.file-manager-progress-bar').fadeOut(100).css( 'width', 0 + '%' );
	        	}, 3000);
	        }
	    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
    };

    this.loadFile = function(page){
    	if($(".file-manager-loader").length > 0){
    		_loader = $(".file-manager-loader");
    		_url    = PATH + "file_manager/ajax_load_files";
    		_data   = $.param({token:token, page: page});
    		if(!$(".file-manager-loading").length > 0){
				_loader.append('<div class="file-manager-loading"></div>');
			}
    		$.post(_url, _data, function(_result){
                $(".file-manager-total-item").html(_result.total_item);
    			if(page == 0){
                    _loader.html(_result.data);
                }else{
                    $(".file-manager-loading").remove();
                    _loader.append(_result.data); 
                }

                if($(".file-manager-scrollbar").length > 0){
                    const ps = new PerfectScrollbar('.file-manager-scrollbar', {
                      wheelSpeed: 2,
                      wheelPropagation: true,
                      minScrollbarLength: 20
                    });

                    $(".file-manager-scrollbar").scroll(function(e) {
                        $(window).resize();
                    });
                }

                $(".lazy").Lazy({
                    afterLoad: function(element) {
                        _image = element.attr("src");
                        element.parents(".item").css({ 'background-image' : 'url('+ _image +')' });
                        element.remove();
                    }
                });
    		}, "json");
    	}
    };

    this.addFile = function(_link){
        $(".file-manager-list-images .add-image").hide();
        if(self.type_select != "multi"){
            $(".file-manager-list-images .item").remove();
        }
        _link_arr = _link.split(".");
        if(_link_arr[_link_arr.length - 1] == "mp4"){
            $(".file-manager-list-images").append('<div class="item"><video src="'+_link+'" playsinline="" muted="" loop=""></video><input type="hidden" name="media[]" value="'+_link+'"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }else{
            $(".file-manager-list-images").append('<div class="item" style="background-image: url('+_link+')"><input type="hidden" name="media[]" value="'+_link+'"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    };

    this.deleteFile = function(){
    	$(document).on("click", ".deleteSingleFile", function(){
    		_that = $(this);
    		_item = _that.parents(".item");
    		_id   = _that.data("id");
    		_url  = _that.attr("href");
    		_data = $.param({token:token, id: _id});

    		$.post(_url, _data, function(_result){
    			if(_result.status == "success"){
    				_item.css('width','0px').css('margin-right','0px');
    				_item.css('opacity',0);
    				setTimeout(function() {
    					_item.remove();
                        _total_item = $(".file-manager-total-item").html();
                        $(".file-manager-total-item").html(parseInt(_total_item) - 1);
					}, 500);
    			}else{

    			}
    		}, 'json');
    		return false;
    	});

    	$(document).on("click", ".delete_multi_files", function(){
    		_that = $(this);
    		_form = _that.parents("form");
    		_data = _form.serialize() + "&" + $.param({token:token});
    		_url  = PATH + 'file_manager/delete_files';
			if (_data.indexOf("id%5B%5D") != -1) {
	    		$.post(_url, _data, function(_result){
	    			self.loadFile(0);
	    			$(".select_multi_files").removeClass("checked");
	    		});
	    	}
    		return false;
    	});
    };

    this.ImageEditor = function(){
        /* edit Images using aviary */
        var featherEditor = new Aviary.Feather({
            //DOCUMENTATION IS AVAILABLE HERE https://creativesdk.adobe.com/docs/web/#/articles/gettingstarted/index.html 
            apiKey: AVIARY_API_KEY, // your api key , you can get one from http://developers.aviary.com/
            //THUTS MY API KEY U CUN USE THUT OR CREATE UR OWN..
            apiVersion: 3, // the api version .
            theme: 'light', // 'light' or 'dark'
            tools: 'all',  // specify tools here.              
            appendTo: '',
            onSave: function(imageID, newURL) {
                self.saveFile(newURL);
                featherEditor.close();
            },
            onError: function(errorObj) { 
                self.notify(errorObj.message, "error");
            },
        });

        $(document).on('click', '.editImage', function() {
            var url = $(this).data("file");
            featherEditor.launch({
                image: "transparent",
                url: url
            });
            return false;
        });
    };

    this.watermark = function(){
        self.watermark_render($(".wt-positions .wt-position-item.active"));

        $("#upload_watermark").change(function() {
            input = this;

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.wt-render').remove();
                    $(".wt-image").append('<img class="wt-render" src="'+e.target.result+'">');
                    setTimeout(function(){
                        self.watermark_render($(".wt-positions .wt-position-item.active"));
                    }, 50);
                }

                reader.readAsDataURL(input.files[0]);
            }
        });

        $(".wt-size, .wt-transparent").change(function(){
            self.watermark_render($(".wt-positions .wt-position-item.active"));
        });

        $(".wt-positions .wt-position-item").click(function(){
            self.watermark_render($(this));
        });

        $('input[type="range"]').ionRangeSlider({
            min: 0,
            max: 100
        });

        self.watermark_upload("#upload_watermark");
    };

    this.watermark_upload = function(_id){
        var url = PATH + "tools/ajax_upload_watermark";
        if(_id != undefined);
        _id = (_id == undefined)?"#fileupload":_id;

        $(_id).fileupload({
            url: url,
            dataType: 'json',
            autoUpload: true,
            done: function (e, data) {
                overplay.hide();
                self.notify(data.result.message, data.result.status);
            },
            progressall: function (e, data) {
                self.overplay();
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('.file-manager-progress-bar').show().css( 'width', progress + '%' );
            },
            stop: function (e, data) {
                setTimeout(function(){
                    $('.file-manager-progress-bar').fadeOut(100).css( 'width', 0 + '%' );
                }, 3000);
            },
            add: function (e, data) {
                $(".btnUploadWatermark").on('click',function () {
                    _size = $(".wt-size").val();
                    _transparent = $(".wt-transparent").val();
                    _position = $(".wt-position").val();
                    data.formData = { token: token, size: _size, opacity: _transparent, position: _position };
                    data.submit();
                    $("#upload_watermark").val('');
                    return false;
                });
            }
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');

        $(document).on("click", ".btnUploadWatermark", function(){
            event.preventDefault();    
            var _that           = $(this);
            var _action         = PATH + "tools/ajax_upload_watermark";

            _size = $(".wt-size").val();
            _transparent = $(".wt-transparent").val();
            _position = $(".wt-position").val();
            _data = $.param({ token: token, size: _size, opacity: _transparent, position: _position });

            Main.ajax_post(_that, _action, _data, null);
            return false;
        });
    };

    this.watermark_render = function(_that){
        _size = $(".wt-size").val();
        _transparent = $(".wt-transparent").val();
        
        $('.wt-render').css({"width": _size+"%"});
        $('.wt-render').css({"opacity": (_transparent/100)});

        _width = $(".wt-render").width();
        _height = $(".wt-render").height();
        _type = _that.data("direction");
        _that.addClass('active').siblings().removeClass('active');
        $(".wt-position").val(_type);
        switch(_type){
            case "lt":
                $('.wt-render').css({"top": 0, "left": 0, "margin-left": 0, "margin-top": 0});
                break;

            case "ct":
                $('.wt-render').css({"top": 0, "left": 50+"%", "margin-left": "-"+_width/2+"px", "margin-top": 0});
                break;

            case "rt":
                $('.wt-render').css({"top": 0, "right": 0, "left": "inherit", "margin-left": 0, "margin-top": 0});
                break;

            case "lc":
                $('.wt-render').css({"top": 50+"%", "left": 0, "margin-left": 0, "margin-top": "-"+_height/2+"px"});
                break;

            case "cc":
                $('.wt-render').css({"top": 50+"%", "left": 50+"%", "margin-left": "-"+_width/2+"px", "margin-top": "-"+_height/2+"px"});
                break;

            case "rc":
                $('.wt-render').css({"top": 50+"%", "right": 0, "left": "inherit", "margin-left": 0, "margin-top": "-"+_height/2+"px"});
                break;

            case "lb":
                $('.wt-render').css({"bottom": 0, "left": 0, "top": "inherit", "margin-left": 0});
                break;

            case "cb":
                $('.wt-render').css({"bottom": 0, "left": 50+"%", "top": "inherit", "margin-left": -_width/2+"px"});
                break;

            case "rb":
                $('.wt-render').css({"bottom": 0, "right": 0, "top": "inherit", "left": "inherit", "margin-left": 0});
                break;
        }
    };

    this.overplay = function(){
        if($(".file-manager-progress-bar").length <= 0){
            overplay.show();
            if($(".modal").hasClass("in")){
                overplay.addClass("top");
            }else{
                overplay.removeClass("top");
            }
        }
    };

    this.hide_overplay = function(){
        overplay.hide();
    };

    this.notify = function(_message, _type){
        switch(_type){
            case "success":
                backgroundColor = "#16D39A";
                break;

            case "error":
                backgroundColor = "#FF7588";
                break;

            default:
                backgroundColor = "#CCD5DB";
                break;
        }

        iziToast.show({
            theme: 'dark',
            icon: 'ft-bell',
            title: '',
            position: 'bottomCenter',
            message: _message,
            backgroundColor: backgroundColor,
            progressBarColor: 'rgb(0, 255, 184)',
        });
    };
}

FileManager= new FileManager();
$(function(){
    FileManager.init();
});

// The Browser API key obtained from the Google API Console.
var developerKey = GOOGLE_API_KEY;

// The Client ID obtained from the Google API Console. Replace with your own Client ID.
var clientId = GOOGLE_CLIENT_ID;

// Replace with your own project number from console.developers.google.com.
// See "Project number" under "IAM & Admin" > "Settings"
// Scope to use to access user's photos.
var scope = ['https://www.googleapis.com/auth/drive'];

var pickerApiLoaded = false;
var oauthToken;

// Use the API Loader script to load google.picker and gapi.auth.
function onApiLoad() {
    gapi.load('auth', {'callback': onAuthApiLoad});
    gapi.load('picker', {'callback': onPickerApiLoad});
}

function onAuthApiLoad() {
    window.gapi.auth.authorize({
        'client_id': clientId,
        'scope': scope,
        'immediate': false
    }, handleAuthResult);
}

function onPickerApiLoad() {
    pickerApiLoaded = true;
    createPicker();
}

function handleAuthResult(authResult) {
    if (authResult && !authResult.error) {
        oauthToken = authResult.access_token;
        createPicker();
    }
}

// Create and render a Picker object for picking user Photos.
function createPicker() {
    if (pickerApiLoaded && oauthToken) {
        var view = new google.picker.View(google.picker.ViewId.DOCS);
        view.setMimeTypes("image/png,image/jpg,video/mp4");
        var picker = new google.picker.PickerBuilder()
            .enableFeature(google.picker.Feature.NAV_HIDDEN)
            .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
            .setOAuthToken(oauthToken)
            .addView(view)
            .addView(new google.picker.DocsUploadView())
            .setDeveloperKey(developerKey)
            .setCallback(pickerCallback)
            .build();
         picker.setVisible(true);
  }
}

// A simple callback implementation.
function pickerCallback(data) {
    var action = data[google.picker.Response.ACTION];
    if (action == google.picker.Action.PICKED) {
        if(data[google.picker.Response.DOCUMENTS] != undefined){
            var doc       = data[google.picker.Response.DOCUMENTS][0];
            var fileId    = doc[google.picker.Document.ID];
            var file_name = doc[google.picker.Document.NAME];
            var file_size = doc['sizeBytes'];
            if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
                FileManager.overplay();
                $("body > .picker").remove();
                $('.file-manager-progress-bar').show().css( 'width', 50 + '%' );
                $.ajax({
                    type: "POST",
                    datatype: 'json',
                    url: PATH + "file_manager/save_image_google_drive",
                    data: { token: token, file_id:fileId, file_name: file_name, file_size: file_size, oauthToken:oauthToken },
                    success: function(_result){ 
                        FileManager.hide_overplay();
                        _result = JSON.parse(_result);  
                        if(_result.status == "success"){
                            FileManager.addFile(_result.link);
                            FileManager.loadFile(0);
                        }else{
                            FileManager.notify(_result.message, _result.status);
                        }

                        $('.file-manager-progress-bar').show().css( 'width', 100 + '%' );
                        setTimeout(function(){
                            $('.file-manager-progress-bar').fadeOut(100).css( 'width', 0 + '%' );
                        }, 3000);
                    }
                });
            }
        }
    }else if (action == google.picker.Action.CANCEL) {
        
    }
}