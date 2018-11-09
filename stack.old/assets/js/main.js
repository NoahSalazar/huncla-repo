function Main(){
    var self= this;
    var DataTable = false;
    var overplay = $(".loading-overplay");
    this.init= function(){
    	//Call Function
        self.optionMain();
        self.actionCaption();
        self.actionItem();
        self.actionMultiItem();
        self.actionForm();
        self.enableDatatable();
        self.emojioneArea();
        self.actionIP();
    };

    this.optionMain = function(){
    	$('[data-toggle="tooltip"]').tooltip({container: "body", trigger : 'hover'}); 

        if($('.box-report').length > 0){
            setTimeout(
                function(){
                    $(".box-report li:first-child .actionItem").trigger("click");
                }, 300
            );

            $(document).on("click", ".box-report li .actionItem", function(){
                $(this).parent().addClass("active").siblings().removeClass("active");
            });
        }

        if($('.datetime').length > 0 || $('.date').length > 0){
	        $('.datetime').bootstrapMaterialDatePicker({ format : ' DD/MM/YYYY HH:mm', lang : 'en', weekStart : 1, currentDate: moment().format(' DD/MM/YYYY HH:mm') });
            $('.date').bootstrapMaterialDatePicker({ format : "MMM DD, YYYY", weekStart : 0, time: false, currentDate: moment().format('MMM DD, YYYY') });
        }

	    /*List account*/
	    $(document).on("click", ".list-account .item", function(){
	    	_that = $(this);
	    	if(_that.hasClass("active")){
	    		_that.removeClass("active");
	    		_that.find("input").removeAttr('checked');
	    	}else{
	    		_that.addClass("active");
	    		_that.find("input").attr('checked','checked');
	    	}
	    });

        /*Payment Tabs*/
        $(".payment-tabs .item:first-child a").trigger("click");
        $(document).on("click", ".payment-tabs a", function(){
            $(this).parents(".item").addClass("active").siblings().removeClass("active");
        });

        $(document).on("click", ".payment-plan a", function(){
            $(this).find("input").prop('checked',true);
            $(this).parents(".item").addClass("active").siblings().removeClass("active");
        });

        /*Select search*/
        if($('select.selectpicker').length > 0 || $('.date').length > 0){
            $('select.selectpicker').selectpicker();
        }

        /*Select all*/
        $(document).on("change", ".checkAll", function(){
            _that = $(this);
            if($('input:checkbox').hasClass("checkItem")){
                if(!_that.hasClass("checked")){
                    $('input.checkItem:checkbox').prop('checked',true);
                    _that.addClass('checked');
                }else{
                    $('input.checkItem:checkbox').prop('checked',false);
                    _that.removeClass('checked');        
                }
            }
            return false;
        });

        /*Enable Schedule*/
        $(document).on("change", "#cb-schedule", function(){
            if($("#cb-schedule").is(':checked')){
                $("#schedule-option").removeClass("hide");
            }else{
                $("#schedule-option").addClass("hide");
            }
        });

        /*Ajax Load Modal*/
        $(document).on("click", ".ajaxModal", function(){
            var url = $(this).attr('href');
            $('#mainModal').load(url,function(){
                $('#mainModal').modal({
                    backdrop: 'static',
                    keyboard: false 
                });
                $('#mainModal').modal('show');
            });
            return false;
        });

        /*Schedules*/
        if($(".schedules-list").length > 0){
            var _page    = 1;
            var _that    = $(".schedules-list");
            var _action  = _that.data("action")
            var _type    = _that.find("[name='schedule_type']").val();
            var _account = _that.find("[name='schedule_account']").val();
            var _data    = $.param({token:token, page: 0, type: _type, account: _account});
            self.ajax_post(_that, _action, _data, null);

            $(".schedules-list select[name='schedule_account']").change(function(){
                _that.find(".ajax-sc-list").html('');
                _type    = _that.find("[name='schedule_type']").val();
                _account = _that.find("[name='schedule_account']").val();
                _data    = $.param({token:token, page: 0, type: _type, account: _account});
                self.ajax_post(_that, _action, _data, null);
            }); 

            $(window).scroll(function(){
                _scrollbar_pos = $(window).scrollTop();
                _widown_height = $(document).height() - $(window).height();
                if(_scrollbar_pos >= _widown_height*0.95){

                    _processing = true;
                    if(_processing){
                        _processing = false;
                        _id = _that.attr("data-id");
                        _data   = $.param({token:token, page: _page, id: _id});
                        _return = self.ajax_post(_that, _action, _data, null);
                        if(!_return){

                            _processing = true;
                            _page = _page + 1;
                            $(".schedules-list").attr("data-page", _page);

                        }
                    }

                }

            });
        }

        
        $(document).on("click", ".schedule-old-list", function(){
            $(".monthly-cal").trigger("click");
        });

        $(document).on("click", ".schedule-old-list a", function(){
            _that = $(this);
            _herf = _that.attr("href");
            $(".monthly-cal").trigger("click");
            location.assign(_herf);
            return false;
        });


        if($(".schedule-old-scrollbar").length > 0){
            $('.schedule-old-scrollbar').niceScroll({cursorcolor:"#ddd"});
        }
        $(document).on("click", ".schedule-old-open", function(){
            _that = $(this);
            _main = _that.parents(".schedule-old");
            _day  = _main.attr("data-day");
            $(".monthly-cal").trigger("click");
            if(!_main.hasClass("open")){

                _main.addClass("open");
                _data = {token: token, day: _day};
                $.post(PATH+"schedules/social_list", _data, function(_result){
                    _main.find(".schedule-old-list").html(_result).slideDown();
                });

            }else{
                _main.removeClass("open");
                _main.find(".schedule-old-list").html("");
            }

            return false;
        });
    };

    this.emojioneArea = function(){
        //Emoji texterea
        if($('.post-message').length > 0){
            el = $(".post-message").emojioneArea({
                hideSource: true,
                useSprite: false,
                pickerPosition    : "bottom",
                filtersPosition   : "top",
            });


            setTimeout(function(){
                $(".emojionearea-editor").niceScroll({cursorcolor:"#ddd"});
            }, 1000);
        }
    };

    this.enableDatatable= function(table_full){
        /*Reponsive table*/
        if($('.table-datatable').length > 0 && $(".table_empty").length == 0){
            if(table_full == undefined){
                $('.table-datatable').DataTable({
                    responsive: true,
                    searching: false,
                    paging: false,
                    info: false,
                    scrollX: false,
                    autoWith: false,
                    bSort : false,
                    language: {
                        emptyTable: " ",
                        zeroRecords: " "
                    }
                });
            }else{
                var extensions = {
                    "sFilter": "dataTables_filter right form-group p15 mb0"
                }
                // Used when bJQueryUI is false
                $.extend($.fn.dataTableExt.oStdClasses, extensions);
                // Used when bJQueryUI is true
                $.extend($.fn.dataTableExt.oJUIClasses, extensions);

                $.extend( $.fn.dataTableExt.oStdClasses, {
                    "sFilterInput": "form-control lead mb0"
                });

                DataTable = $('.table-datatable').DataTable({
                    responsive: true,
                    searching: true,
                    paging: false,
                    info: false,
                    scrollX: false,
                    autoWith: false,
                    bSort : true,
                    language: {
                        emptyTable: " ",
                        zeroRecords: " ",
                        search: " "
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });

                $('.dataTables_filter input').attr("placeholder", enter_keyword_to_search);
            }
        }
    };

    this.actionCaption = function(){
        var _wrap_caption = $(".load-caption");
        var _body_caption = $(".load-caption .caption-body");

        //Get Caption
        $(document).on("click", ".getCaption", function(){
            _that = $(this);
            _name = _that.parents(".form-caption").find("textarea").attr("name");
            _wrap_caption.attr("data-field", _name).fadeIn();

            self.statusCardOverplay("show");
            self.statusCardOverplay("hide");

            _data = { token : token };

            $.post(PATH+"caption/get_caption", _data, function(_result){
                _body_caption.append(_result);
            });
            return false;
        });

        $(document).on("click", ".saveCaption", function(){
            _that = $(this);
            _caption = _that.parents(".form-caption").find("textarea").val();
            _data = {token: token, caption: _caption};
            
            if(_caption != ""){
                self.overplay();
                $.post(PATH+"caption/save_caption", _data, function(_result){
                    //Message
                    if(_result.status != undefined){
                        self.notify(_result.message, _result.status);
                    }

                    overplay.hide();
                }, 'json');
            }
            return false;
        });

        $(document).on("click", ".load-caption .item", function(){
            _that = $(this);
            _name = _wrap_caption.attr("data-field");
            _caption = _that.attr("data-content");

            var el = $("textarea[name='"+_name+"']").emojioneArea();
            el[0].emojioneArea.setText(_caption);

            setTimeout(function(){
                _body_caption.find(".scroll-content").html("");
            }, 300);
            _wrap_caption.fadeOut();
        });

        $(document).on("click", ".caption-load-more", function(){
            _that = $(this);
            _page = _that.attr("data-page");
            _body_caption = $(".load-caption .caption-body");

            $(".wrap-load-more").remove();
            $.post(PATH+"caption/get_caption/"+_page, _data, function(_result){
                _body_caption.append(_result);
            });
            return false;
        });

        $(document).on("click", ".load-caption .caption-close", function(){
            _body_caption.find(".scroll-content").html("");
            _wrap_caption.fadeOut();
        });
    };

    this.actionIP = function(){
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://timezoneapi.io/api/ip",
            "method": "GET",
            "headers": {}
        }

        $.ajax(settings).done(function (response) {
            timezone = response.data.timezone.id;
            $.post(PATH+"oauth/timezone", {token:token, timezone:timezone}, function(_result){});
            $(".auto-select-timezone").val(timezone);
        });
    };

    this.actionItem= function(){
        $(document).on('click', ".actionItem", function(event) {
            event.preventDefault();    
            var _that           = $(this);
            var _action         = _that.attr("href");
            var _id             = _that.data("id");
            var _data           = $.param({token:token, id: _id});

            self.ajax_post(_that, _action, _data, null);
            return false;
        });
    };

    this.actionMultiItem= function(){
        $(document).on('click', ".actionMultiItem", function(event) {
            event.preventDefault();    
            var _that           = $(this);
            var _form           = _that.closest("form");
            var _action         = _that.attr("href");
            var _params         = _that.data("params");
            var _data           = _form.serialize();
            var _data           = _data + '&' + $.param({token:token}) + "&" + _params;
            self.ajax_post(_that, _action, _data, null);
            return false;
        });
    };

    this.actionForm= function(){
        $(document).on('submit', ".actionForm", function(event) {
            event.preventDefault();    
            var _that           = $(this);
            var _action         = _that.attr("action");
            var _data           = _that.serialize();
            var _data           = _data + '&' + $.param({token:token});
            
            self.ajax_post(_that, _action, _data, null);
        });
    };

    this.ajax_post = function(_that, _action, _data, _function){
        var _confirm        = _that.data("confirm");
        var _transfer       = _that.data("transfer");
        var _type_message   = _that.data("type-message");
        var _rediect        = _that.data("redirect");
        var _content        = _that.data("content");
        var _append_content = _that.data("append_content");
        var _callback       = _that.data("callback");
        var _hide_overplay  = _that.data("hide-overplay");
        var _type           = _that.data("result");
        var _object         = false;
        if(_type == undefined){
            _type = 'json';
        }

        if(_confirm != undefined){
            if(!confirm(_confirm)) return false;
        }

        if(!_that.hasClass("disabled")){
            if(_hide_overplay == undefined || _hide_overplay == 1){
                self.overplay();
            }
            _that.addClass("disabled");
            $.post(_action, _data, function(_result){
                
                //Check is object
                if(typeof _result != 'object'){
                    try {
                        _result = $.parseJSON(_result);
                        _object = true;
                    } catch (e) {
                        _object = false;
                    }
                }else{
                    _object = true;
                }

                //Run function
                if(_function != null){
                    _function.apply(this, [_result]);
                }

                //Callback function
                if(_result.callback != undefined){
                    self.callbacks(_result.callback);
                }

                //Callback
                if(_callback != undefined){
                    var fn = window[_callback];
                    if (typeof fn === "function") fn(_result);
                }

                //Using for update
                if(_transfer != undefined){
                    _that.removeClass("tag-success tag-danger").addClass(_result.tag).text(_result.text);
                }

                //Add content
                if(_content != undefined && _object == false){
                    if(_append_content != undefined){
                        $("."+_content).append(_result);
                    }else{
                        $("."+_content).html(_result);
                    }

                    //Enable DataTable
                    if(_result.search("table-datatable") != -1){
                        self.enableDatatable(true);
                    }
                }

                //Hide Loading
                overplay.hide();
                _that.removeClass("disabled");

                //Redirect
                self.redirect(_rediect, _result.status);

                //Message
                if(_result.status != undefined){
                    switch(_type_message){
                        case "text":
                            self.notify(_result.message, _result.status);
                            break;

                        default:
                            self.notify(_result.message, _result.status);
                            break;
                    }
                }

            }, _type).fail(function() {
                _that.removeClass("disabled");
            });
        }

        return false;
    };

    this.callbacks = function(_function){
        $("body").append(_function);
    };

    this.overplay = function(){
        overplay.show();
        if($(".modal").hasClass("in")){
            overplay.addClass("top");
        }else{
            overplay.removeClass("top");
        }
    };

    this.redirect = function(_rediect, _status){
        if(_rediect != undefined && _status == "success"){
            setTimeout(function(){
                window.location.assign(_rediect);
            }, 1500);
        }
    };

    this.notify = function(_message, _type){
        if(_message != undefined && _message != ""){
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
        }
    };

    this.statusOverplay = function(_status){
        if(_status == undefined || _status == "show"){
            $(".hide-overplay").addClass("loading-overplay").removeClass("hide-overplay");
        }else{
            $(".loading-overplay").addClass("hide-overplay").removeClass("loading-overplay");
        }
    };

    this.statusCardOverplay = function(_status){
        if(_status == undefined || _status == "show"){
            $(".card-overplay").fadeIn();
        }else{
            $(".card-overplay").fadeOut();
        }
    };

    this.removeParam = function(key, sourceURL) {
        var rtn = "",
            param,
            params_arr = [],
            queryString = sourceURL.split("?")[0];
        if (queryString !== "") {
            params_arr = queryString.split("&");
            for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                param = params_arr[i].split("=")[0];
                if (param === key) {
                    params_arr.splice(i, 1);
                }
            }
            rtn = params_arr.join("&");
        }
        return rtn;
    };
}
Main= new Main();
$(function(){
    Main.init();
});


function executeFunctionByName(functionName, context /*, args */) {
  var args = Array.prototype.slice.call(arguments, 2);
  var namespaces = functionName.split(".");
  var func = namespaces.pop();
  for(var i = 0; i < namespaces.length; i++) {
    context = context[namespaces[i]];
  }
  return context[func].apply(context, args);
}