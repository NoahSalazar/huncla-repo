function Facebook(){
    var self= this;
    var _current_link = "";
    var _current_link_photos = [];
    var _started = false;
    this.init= function(){
        if($(".facebook-app").length > 0){
            self.optionFacebook();
            self.loadPreview();
        }
    };

    this.optionFacebook = function(){
        $("#profiles .actionItem").click();
        $(document).on("click", ".actionLoadFB", function(){
            $("#profiles .actionItem").click();
        });

        /*Select all*/
        $(document).on("change", ".checkAll", function(){
            _that = $(this);
            if($('input:checkbox').hasClass("checkItem")){
                _ids = "";
                _el  = $("tbody input[name='id[]']");
                if(_that.hasClass("checked")){
                    _el.each(function(index){
                        _ids += $(this).val() + ((_el.length != index + 1)?",":"");
                    });    
                }

                $("input[name='list_ids']").val(_ids);
            }
        });

        $(document).on("change", "tbody input[name='id[]']", function(){
            _that = $(this);
            _ids  = "";
            _el   = $("tbody input[name='id[]']:checked");
            _el.each(function(index){
                _ids += $(this).val() + ((_el.length != index + 1)?",":"");
            });

            $("input[name='list_ids']").val(_ids);
        });

        //Select type post
        $(document).on("click", ".schedule-facebook-type .item", function(){
            _that = $(this);
            _type = _that.data("type");
            _that.addClass("active");
            _that.siblings().removeClass("active");
            _that.siblings().find("input").removeAttr('checked');
            _that.find("input").attr('checked','checked');

            if(_type == "text" || _type == "link"){
                $(".image-manage").hide();
            }else{
                $(".image-manage").show();
            }

            if(_type != "link"){
                $("#link").removeClass("active");
            }

            $(".preview-fb").addClass("hide");
            $(".preview-fb-"+_type).removeClass("hide");
            self.defaultPreview();
        });

        //Enable Schedule
        $(document).on("change", ".enable_facebook_schedule", function(){

            _that = $(this);
            if(!_that.hasClass("checked")){
                $('.postnow-option').addClass("hide");
                $('.schedule-option').removeClass("hide");
                $('.btnPostNow').addClass("hide");
                $('.btnSchedulePost').removeClass("hide");
                _that.addClass('checked');
            }else{
                $('.postnow-option').removeClass("hide");
                $('.schedule-option').addClass("hide");
                $('.btnPostNow').removeClass("hide");
                $('.btnSchedulePost').addClass("hide");
                _that.removeClass('checked');        
            }
            return false;
        });

        $(document).on("click", ".file-manager-list-images .item .close", function(){
            if($(".file-manager-list-images .item").length <= 0){
               self.defaultPreview();
            }
        });

        $(document).on("click", ".facebook-app .btnPostNow", function(){
            _that = $(this);
            self.postNow(_that);
        });

        //Load link
        $(document).on("change", ".facebook-app input[name='link']", function(){
            _that   = $(this);
            _link   = _that.val();
            _action = PATH+"facebook/post/ajax_get_link";
            _data   = $.param({token:token, link: _link});

            if(_link == ""){
                return false;
            }

            $(".facebook-app .preview-fb-link .image").removeAttr("style");
            $(".facebook-app .preview-fb-link .title").html('<div class="line-no-text"></div>');
            $(".facebook-app .preview-fb-link .desc").html('<div class="line-no-text"></div><div class="line-no-text"></div><div class="line-no-text"></div>');
            $(".facebook-app .preview-fb-link .website").html('<div class="line-no-text w50"></div>');

            Main.ajax_post(_that, _action, _data, function(_result){
                if(_result.status == "success"){
                    if(_result.image != "")
                        $(".facebook-app .preview-fb-link .image").css({'background-image': 'url(' + _result.image + ')'});
                    if(_result.title != "")
                        $(".facebook-app .preview-fb-link .title").html(_result.title);

                    if(_result.description != "")
                        $(".facebook-app .preview-fb-link .desc").html(_result.description);
                    if(_result.host != "")
                        $(".facebook-app .preview-fb-link .website").html(_result.host);
                }
            });
        });

        //Review content
        if($(".facebook-app .post-message").length > 0){
            $(".facebook-app .post-message").data("emojioneArea").on("keyup", function(editor) {
                _data = editor.html();
                if(_data != ""){
                    $(".caption-info").html(_data);
                }else{
                    $(".caption-info").html('<div class="line-no-text"></div><div class="line-no-text"></div><div class="line-no-text w50"></div>');
                }
            });

            $(".facebook-app .post-message").data("emojioneArea").on("change", function(editor) {
                _data = editor.html();
                if(_data != ""){
                    $(".caption-info").html(_data);
                }else{
                    $(".caption-info").html('<div class="line-no-text"></div><div class="line-no-text"></div><div class="line-no-text w50"></div>');
                }
            });

            $(".facebook-app .post-message").data("emojioneArea").on("emojibtn.click", function(editor) {
                _data = $(".emojionearea-editor").html();
                if(_data != ""){
                    $(".caption-info").html(_data);
                }else{
                    $(".caption-info").html('<div class="line-no-text"></div><div class="line-no-text"></div><div class="line-no-text w50"></div>');
                }
            });
        }
    };

    this.postNow = function(_that){
        _form     = _that.closest("form");
        _action   = _form.attr("action");
        _data     = _form.serialize();
        _data     = _data + '&' + $.param({token:token});
        _stop     = false;
        _interval = _form.find("[name='postnow_delay']").val();

        Main.statusOverplay("hide");
        Main.statusCardOverplay("show");

        Main.ajax_post(_that, _action, _data, function(_result){
            Main.statusOverplay("show");
            _started = true;

            //Remove mark item
            if(_result.stop == undefined){
                if(_result.status == "success"){
                    $("input[value='"+_result.ids+"']").trigger("click").parents("tr").find(".ajax_result").html(_result.result);
                }else{
                    $("input[value='"+_result.ids+"']").trigger("click").parents("tr").find(".ajax_result").html(_result.result);
                }

                _list_ids = $("input[name='list_ids']").val();
                if(_list_ids != ""){
                    setTimeout(function(){
                        $(".btnPostNow").trigger("click");
                    }, _interval*1000);
                }else{
                    Main.statusCardOverplay("hide");
                }
            }else{
                Main.statusCardOverplay("hide");
            }
            $('.webuiPopover').webuiPopover('destroy').webuiPopover({content: 'Content' , width: 250, trigger: 'hover'});
        });
    };

    this.search_group = function(result){
        $('.table-datatable').dataTable().fnDestroy();

        if($("input[name='keep_data']:checked").length > 0){
            if($(".table").length > 0){
                $(".facebook-join-group-content").removeClass('facebook-join-group-data');
                $(".app-table tbody").addClass('facebook-join-group-data');
                $(".facebook-join-group-data").append(result);
            }else{
                $(".facebook-join-group-data").html(result);
            }
        }else{
            $(".facebook-join-group-content").addClass('facebook-join-group-data');
            $(".app-table tbody").removeClass('facebook-join-group-data');
            $(".facebook-join-group-data").html(result);
        }

        Main.enableDatatable(true);
    };

    this.loadPreview = function(){
        //Load Preview
        setInterval(function(){ 
            _type  = $(".schedule-facebook-type .item.active").data("type");
            _media = $(".file-manager-list-images .item");
            if(_media.length > 0){
                switch(_type){
                    case "media":
                        list_images = [];
                        $check = true;

                        $("input[name='media[]']").each(function( index ) {
                            list_images.push($(this).val());
                            if(_current_link_photos.indexOf($(this).val()) == -1 || _current_link_photos.length != $("input[name='media[]']").length){
                                $check = false;
                            }
                        });
                        if($check == false){
                            _current_link_photos = list_images;
                            _count_image = list_images.length > 5?5:list_images.length;
                            _count_now = 1;
                            $(".preview-fb-media .preview-image").attr("class", "preview-image").addClass("preview-media" + _count_image).html('');
                            for (i = 0; i < list_images.length; i++) {
                                _link_arr = list_images[i].split(".");
                                if(_link_arr[_link_arr.length - 1] != "mp4"){
                                    $(".preview-fb-media .preview-image").append('<div class="item" style="background-image: url('+list_images[i]+')">'+((_count_now == 5 && list_images.length > 5)?'<div class="count">+'+(list_images.length-4)+'</div>':'')+'</div>');
                                }else{
                                    _text = '<div class="count"><i class="fa fa-play" aria-hidden="true"></i></div>';
                                    if(_count_now == 5 && list_images.length > 5){
                                        _text = '<div class="count">+'+(list_images.length-4)+'</div>';
                                    }
                                    $(".preview-fb-media .preview-image").append('<div class="item"><video src="'+list_images[i]+'" playsinline="" muted="" loop=""></video>'+_text+'</div>');
                                }

                                _count_now++;
                            }
                        }
                        break;

                    case "video":
                        _link     = _media.find("input").val();
                        _link_arr = _link.split(".");
                        if(_current_link != _link){
                            if(_link_arr[_link_arr.length - 1] == "mp4"){
                                $(".preview-vk-video .preview-image").html('<video src="'+_link+'" playsinline="" autoplay="" muted="" loop=""></video>');
                                $(".preview-vk-video .preview-image").css({"background-image": "none"});
                            }
                            _current_link = _link;
                        }
                        break;

                    case "text":
                        break
                }
            }
        }, 1500);
    };

    this.defaultPreview = function(){
        $(".preview-fb-media .preview-image").attr("class", "preview-image").html('');
    };
}

Facebook= new Facebook();
$(function(){
    Facebook.init();
});

function search_group(result){
    Facebook.search_group(result);
}