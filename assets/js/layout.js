function Layout(){
    var self= this;
    var chart_color = ["rgba(22,211,154,0.7)", "rgba(255,117,136, 0.7)", "rgba(255,168,125,0.7)", "rgba(156,39,176,0.7)", "rgba(28,188,216,0.7)", "rgba(64,78,103,0.7)"];
    this.init= function(){
    	//Callback
    	self.sidebar();
    	self.optionLayout();
    };

    this.optionLayout = function(){
    	$('.webuiPopover').webuiPopover({content: 'Content' , width: 250, trigger: 'hover'});
    	if($(window).width() > 786){
            $('a.menuPopover').webuiPopover({
                container: "#menucontentwebuiPopover",
                placement: 'right-bottom',
                trigger: 'hover',
                padding: false,
                animation: "fade",
                delay: {
                    show: 200,
                    hide: 100
                },
                content: function(data){
                    setTimeout(function(){
                        if($(".webui-popover.in .menu-scroll-content").length > 0){
                            const ps_menu = new PerfectScrollbar('.menu-scroll-content', {
                              wheelSpeed: 2,
                              wheelPropagation: true,
                              minScrollbarLength: 20
                            });
                            ps_menu.update();
                        }
                    }, 500);
                    var html = "<ul class='menu-content menu-scroll-content'>"+$(this).next().html()+"</ul>";
                    return html;
                }
            });
        }else{
            $(document).on('click', '.sidebar .menuPopover', function(){
                _that = $(this);
                $(".nav-item").removeClass("active");
                $(".nav-item .menu-content").slideUp();
                _that.parents("li").find(".menu-content").slideDown();
            });
        }


		if($(".scrollbar").length > 0){
			$('.scrollbar').scrollbar({
				"autoUpdate" : true
			});
		}

        if($("select.custom").length > 0){
            $("select.custom").each(function() {                    
                var sb = new SelectBox({
                    selectbox: $(this),
                    height: 150,
                    width: 200
                });
            });
        }

    };

    this.pieChart = function(element, lables, data){
        var config = {
            type: 'pie',
            data: {
                datasets: [{
                    data: data,
                    backgroundColor: chart_color,
                    label: 'Dataset 1'
                }],
                labels: lables
            },
            options: {
                responsive: true
            }
        };

        var ctx = document.getElementById(element).getContext("2d");
        window.myPie = new Chart(ctx, config);
    };

    this.lineChart = function(element, label, data, name, type){
        var ctx2 = document.getElementById(element).getContext("2d");

        // Chart Options
        var userPageVisitOptions = {
            responsive: true,
            maintainAspectRatio: false,
            pointDotStrokeWidth : 4,
            legend: {
                display: true,
                labels: {
                    fontColor: '#404e67',
                    boxWidth: 10,
                },
                position: 'bottom',
            },
            hover: {
                mode: 'label'
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        color: "rgba(255,255,255, 0.3)",
                        drawTicks: true,
                        drawBorder: false,
                        zeroLineColor:'#FFF'
                    },
                    ticks: {
                        display: false,
                    },
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        color: "rgba(0,0,0, 0.07)",
                        drawTicks: false,
                        drawBorder: false,
                        drawOnChartArea: true
                    },
                    ticks: {
                        display: true,
                        maxTicksLimit: 5,
                        beginAtZero: true,
                        userCallback: function(label, index, labels) {
                            // when the floored value is the same as the value we have a whole number
                            if (Math.floor(label) === label) {
                                return label;
                            }

                        },
                    },
                }]
            },
            title: {
                display: false,
                text: 'Report last 30 days'
            },
        };

        data_set = [];
        var count_data = data.length;

        for (var i = 0; i < count_data; i++) {
            if(type =="line"){
                data_set.push({
                    label: name[i],
                    data: data[i],
                    backgroundColor: "transparent",
                    borderColor: chart_color[i],
                    pointBorderColor: chart_color[i],
                    pointRadius: 2,
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                });
            }else{
                data_set.push({
                    label: name[i],
                    data: data[i],
                    backgroundColor: chart_color[i],
                    borderColor: "transparent",
                    pointBorderColor: "transparent",
                    pointRadius: 2,
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                });
            }
        }

        // Chart Data
        var userPageVisitData = {
            labels: label,
            datasets: data_set
        };

        var userPageVisitConfig = {
            type: 'line',
            // Chart Options
            options : userPageVisitOptions,
            // Chart Data
            data : userPageVisitData
        };

        // Create the chart
        var stackedAreaChart = new Chart(ctx2, userPageVisitConfig);
    };

    this.sidebar = function(){
    	//Menu
    	var bodyMain = document.getElementById( 'body-main' ),
		showLeft = document.getElementById( 'menu-toggle' ),
		body = document.body;

		showLeft.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( bodyMain, 'body-collapsed' );
			classie.toggle( showLeft, 'disabled' );
		};

    	if($(".menu-scroll").length > 0){
            const ps1 = new PerfectScrollbar('.menu-scroll', {
              wheelSpeed: 2,
              wheelPropagation: true,
              minScrollbarLength: 20
            });
        }

        $("body.menu-full .sidebar .nav-item .menuPopover").hover(function(){
            $('.menuPopover').webuiPopover('destroy');
            $('#menucontentwebuiPopover').remove();
        });

        $(document).on("click", "body.menu-full .sidebar .nav-item a", function(){
            _that = $(this);
            if(_that.next(".menu-content").hasClass("open")){
                _that.next(".menu-content").slideUp(300).removeClass("open");

            }else{
                _that.next(".menu-content").slideDown(300).addClass("open");

            }

        }); 
    };
}
Layout= new Layout();
$(function(){
    Layout.init();
});