function Linkedin(){
    var self= this;
    var _current_link = "";
    var _current_link_photos = [];
    var _started = false;
    this.init= function(){
        if($(".linkedin-app").length > 0){
            self.optionLinkedin();
            self.loadPreview();
        }
    };

    this.optionLinkedin = function(){

        //Enable Schedule
        $(document).on("change", ".enable_linkedin_schedule", function(){
            _that = $(this);
            if(!_that.hasClass("checked")){
                $('.time_post').removeAttr('disabled');
                $('.btnPostNow').addClass("hide");
                $('.btnSchedulePost').removeClass("hide");
                _that.addClass('checked');
            }else{
                $('.time_post').attr('disabled', true);
                $('.btnPostNow').removeClass("hide");
                $('.btnSchedulePost').addClass("hide");
                _that.removeClass('checked');        
            }
            return false;
        });

        //Review content
        if($(".linkedin-app .post-message").length > 0){
            $(".linkedin-app .post-message").data("emojioneArea").on("keyup", function(editor) {
                _data = editor.html();
                if(_data != ""){
                    $(".caption-info").html(_data);
                }else{
                    $(".caption-info").html('<div class="line-no-text"></div><div class="line-no-text"></div><div class="line-no-text w50"></div>');
                }
            });

            $(".linkedin-app .post-message").data("emojioneArea").on("change", function(editor) {
                _data = editor.html();
                if(_data != ""){
                    $(".caption-info").html(_data);
                }else{
                    $(".caption-info").html('<div class="line-no-text"></div><div class="line-no-text"></div><div class="line-no-text w50"></div>');
                }
            });

            $(".linkedin-app .post-message").data("emojioneArea").on("emojibtn.click", function(editor) {
                _data = $(".emojionearea-editor").html();
                if(_data != ""){
                    $(".caption-info").html(_data);
                }else{
                    $(".caption-info").html('<div class="line-no-text"></div><div class="line-no-text"></div><div class="line-no-text w50"></div>');
                }
            });
        }

        //Post now
        $(document).on("click", ".linkedin-app .btnPostNow", function(){
            _that = $(this);
            self.postNow(_that);
        });

        //Load link
        $(document).on("change", ".linkedin-app input[name='link']", function(){
            _that   = $(this);
            _link   = _that.val();
            _action = PATH+"linkedin/post/ajax_get_link";
            _data   = $.param({token:token, link: _link});

            if(_link == ""){
                return false;
            }

            $(".linkedin-app .preview-linkedin-link .title").html('<div class="line-no-text"></div>');
            $(".linkedin-app .preview-linkedin-link .website").html('<div class="line-no-text w50"></div>');

            Main.ajax_post(_that, _action, _data, function(_result){
                if(_result.status == "success"){
                    if(_result.title != "")
                        $(".linkedin-app .preview-linkedin-link .title").html(_result.title);

                    if(_result.host != "")
                        $(".linkedin-app .preview-linkedin-link .website").html(_result.host);
                }
            });
        });
    };

    this.postNow = function(_that){
        _form    = _that.closest("form");
        _action  = _form.attr("action");
        _data    = $("[name!='account[]']").serialize();
        _data    = _data + '&' + $.param({token:token});
        _item    = $(".list-account .item.active");
        _stop    = false;
        if(_item.length > 0){
            _id     = _item.first().find("input").val();
            _data   = _form.serialize();
            _data   = Main.removeParam("account%5B%5D", _data);
            _data   = _data + '&' + $.param({token:token , 'account[]' :_id});
        }else{
            if(_started == true){
                _started = false;
                Main.statusCardOverplay("hide");
                return false;
            }
        }

        Main.statusOverplay("hide");
        Main.statusCardOverplay("show");

        Main.ajax_post(_that, _action, _data, function(_result){
            Main.statusOverplay("show");
            _started = true;

            //Remove mark item
            if(_result.stop == undefined){
                _item.first().trigger("click");
                setTimeout(function(){
                    $(".btnPostNow").trigger("click");
                }, 500);
            }else{
                Main.statusCardOverplay("hide");
            }
        });
    };

    this.loadPreview = function(){
        //Load Preview
        setInterval(function(){ 
            _media = $(".file-manager-list-images .item");
            if(_media.length > 0){
                _link     = _media.find("input").val();
                _link_arr = _link.split(".");
                if(_current_link != _link){
                    $(".preview-linkedin-link .preview-link .image").css({"background-image": "url("+_link+")"});
                    $(".preview-linkedin-link .preview-link .image").html('');
                    _current_link = _link;
                }
            }
        }, 1500);
    };

    this.defaultPreview = function(){
        $(".preview-linkedin-link .preview-image").attr("class", "preview-image").html('');
    };
}

Linkedin= new Linkedin();
$(function(){
    Linkedin.init();
});
