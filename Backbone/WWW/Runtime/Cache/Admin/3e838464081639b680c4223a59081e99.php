<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|BackBone</title>
    <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/my.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="/Public/static/echarts.min.js"></script>
    <style>
        body{
                padding: 50px 0 0 0;
        }
    </style>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <!--<span class="logo"></span>-->
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">hello，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
<!--                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>-->
                <li><a href="<?php echo U('Public/logout');?>">logout</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">this is content</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>Position:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
	<div class="main-title">
		<h2><?php echo ($meta_title); ?></h2>
	</div>
    <h2><?php echo get_nickname();?><button type="button">status:<?php echo ($myInfo["status_text"]); ?></button><button type="button">level:<?php echo ($myInfo["level"]); ?></button></h2>
    XP:
    <div class="progress">
        <div class="progress-bar" style="width: <?php echo ($myInfo[xp]/10); ?>%"></div>
    </div>
	<div class="data-table table-striped">
            <table>
      
                <tbody>
                    <tr>
                        <td>
                            <table class="my-table" border="0" cellspacing="1" cellpadding="1">
                                <caption align="top">My Info</caption>  
                                <tbody>
                                    <tr>
                                        <td colspan="4"><button type="button">Talent_ID:</button> <?php echo ($myInfo["talent_id"]); ?></td>
                                    </tr>
                                    <tr>
                                        <td><button type="button">L_Name:</button> <?php echo ($myInfo["l_name"]); ?></td>
                                        <td><button type="button">M_Name:</button> <?php echo ($myInfo["M_name"]); ?></td>
                                        <td><button type="button">F_Name:</button> <?php echo ($myInfo["f_name"]); ?></td>
                                        <td><button type="button">SSN:</button> <?php echo ($myInfo["ssn"]); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><button type="button">Position_Name:</button> <?php echo ((isset($position["position_name"]) && ($position["position_name"] !== ""))?($position["position_name"]):"none"); ?></td>
                                    </tr>
                                    <tr>
                                        <td><button type="button">Gender:</button> <?php echo ($myInfo["gender_text"]); ?></td>
                                        <td colspan="3"><button type="button">DoB:</button> <?php echo ($myInfo["dob"]); ?></td>
                                    </tr>
                                    <tr>
                                        <td><button type="button">University_Name:</button> <?php echo ($university["university_name"]); ?></td>
                                        <td><button type="button">Degree:</button> <?php echo ($university["degree_text"]); ?></td>
                                        <td colspan="2"><button type="button">GPA:</button> <?php echo ($university["gpa"]); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                        <?php if(!empty($company)): ?><table class="my-table" border="0" cellspacing="1" cellpadding="1">
                                <caption align="top">Company Info</caption>  
                                <tbody>
                                    <tr>
                                        <td><button type="button">Company_Name:</button> <?php echo ((isset($company["company_name"]) && ($company["company_name"] !== ""))?($company["company_name"]):"none"); ?></td>
                                        <td><button type="button">Street:</button> <?php echo ((isset($company["street"]) && ($company["street"] !== ""))?($company["street"]):"none"); ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><button type="button">City:</button> <?php echo ((isset($company["city"]) && ($company["city"] !== ""))?($company["city"]):"none"); ?></td>
                                    </tr>
                                    <tr>
                                        <td><button type="button">Department_Name:</button> <?php echo ((isset($company["department_name"]) && ($company["department_name"] !== ""))?($company["department_name"]):"none"); ?></td>
                                        <td><button type="button">Zip:</button> <?php echo ((isset($company["zip"]) && ($company["zip"] !== ""))?($company["zip"]):"none"); ?></td>
                                    </tr>
                                </tbody>
                            </table><?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            
                            <table>
                                <caption align="top">My Skill</caption>  
                                
                                <thead>
                                    <tr>
                                        <th>Skill_Name</th>
                                        <th>Skill_Score<?php if(($_GET['skillOrder1']) == "1"): ?><a href="<?php echo U('',array('skillOrder1'=>2));?>">↓</a><?php else: ?><a href="<?php echo U('',array('skillOrder1'=>1));?>">↑</a><?php endif; ?></th>
                                        <th>Rank<?php if(($_GET['skillOrder1']) == "3"): ?><a href="<?php echo U('',array('skillOrder1'=>4));?>">↓</a><?php else: ?><a href="<?php echo U('',array('skillOrder1'=>3));?>">↑</a><?php endif; ?></th>
                                        <th>
                                            <select name="Select_Scale">
                                                <option value="<?php echo U('');?>">In the Backbone</option>
                                                <option <?php if(($_GET['in_bc']) == "1"): ?>selected<?php endif; ?> value="<?php echo U('',array('in_bc'=>1));?>">In the Company</option>
                                            </select>
                                            <script>
                                                $(function(){
                                                    $('[name="Select_Scale"]').on('change',function(){
                                                        window.location.href=$('[name="Select_Scale"]').val();
                                                    })
                                                });
                                            </script>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php if(is_array($skill)): $i = 0; $__LIST__ = $skill;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                            <td><?php echo ($vo["skill_name"]); ?></td>
                                            <td><?php echo ($vo["skill_score"]); ?></td>
                                            <td><?php echo ($vo[rank]+1); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </td> 
    
                        <td>
                            <table>
                                <caption align="top">My Personality</caption>  
                                
                                <tbody>
					<tr>
                                            <td align='center'>
                                                <div id='myradar' style='height: 400px;'></div>
                                                <script type="text/javascript">
                                                    // 基于准备好的dom，初始化echarts实例
                                                    var myChart = echarts.init(document.getElementById('myradar'));

                                                    // 指定图表的配置项和数据
                                                    option = {
                                                                    tooltip: {},
                                                                    legend: {
                                                                        data: ['Average Score', 'My Score']
                                                                    },
                                                                    radar: {
                                                                        // shape: 'circle',
                                                                        indicator: [
                                                                           { name: 'J', max: 100},
                                                                           { name: 'E', max: 100},
                                                                           { name: 'T', max: 100},
                                                                           { name: 'S', max: 100},
                                                                           { name: 'I', max: 100},
                                                                           { name: 'N', max: 100},
                                                                           { name: 'F', max: 100},
                                                                           { name: 'P', max: 100},
                                                                        ]
                                                                    },
                                                                    series: [{
                                                                        name: 'My Score vs Average Score',
                                                                        type: 'radar',
                                                                        // areaStyle: {normal: {}},
                                                                        data : [
                                                                            {
                                                                                value : [<?php echo ($aveskill["j"]); ?>, <?php echo ($aveskill["e"]); ?>, <?php echo ($aveskill["t"]); ?>, <?php echo ($aveskill["s"]); ?>, <?php echo ($aveskill["i"]); ?>, <?php echo ($aveskill["n"]); ?>,<?php echo ($aveskill["f"]); ?>,<?php echo ($aveskill["p"]); ?>],
                                                                                name : 'Average Score'
                                                                            },
                                                                             {
                                                                                value : [<?php echo ($myInfo["j"]); ?>, <?php echo ($myInfo["e"]); ?>, <?php echo ($myInfo["t"]); ?>, <?php echo ($myInfo["s"]); ?>, <?php echo ($myInfo["i"]); ?>, <?php echo ($myInfo["n"]); ?>,<?php echo ($myInfo["f"]); ?>,<?php echo ($myInfo["p"]); ?>],
                                                                                name : 'My Score'
                                                                            }
                                                                        ]
                                                                    }]
                                                                };

                                                    // 使用刚指定的配置项和数据显示图表。
                                                    myChart.setOption(option);
                                                </script>
                                            </td>
					</tr>
                                </tbody>
                            </table>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                <?php if(!empty($kpi)): ?><table class="my-table" border="0" cellspacing="1" cellpadding="1">
                                <caption align="top">My KPI & Salary</caption>  
                                <tbody>
                                    <tr>
                                        <td colspan='2'><button type="button">(Current) KPI :</button> <?php echo ($kpi["kpi_period"]); ?></td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'><button type="button">Score :</button> <?php echo ($kpi[score]); ?></td>
                                        <td><?php echo ($kpi[rank_c]); ?>% Rank in Company</td>
                                    </tr>
                                    <tr>
                                        <td><?php echo ($kpi[rank_b]); ?>% Rank in BackBone</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'><button type="button">(Current) Salary : </button> <?php echo ($salary["salary"]); ?></td>
                                        <td><?php echo ($salary[rank_c]); ?>% Rank in Company</td>
                                    </tr>
                                    <tr>
                                        <td><?php echo ($salary[rank_b]); ?>% Rank in BackBone</td>
                                    </tr>
                                </tbody>
                            </table><?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>

	</div>

        </div>
        <div class="cont-ft">
            <div class="copyright">
               
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "", //当前网站地址
            "APP"    : "/index.php?s=", //当前项目地址
            "PUBLIC" : "/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/Public/static/think.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>

<script type="text/javascript">
$(function(){
	//搜索功能
	$("#search").click(function(){
		var url = $(this).attr('url');
        var query  = $('.search-form').find('input').serialize();
        query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
        query = query.replace(/^&/g,'');
        if( url.indexOf('?')>0 ){
            url += '&' + query;
        }else{
            url += '?' + query;
        }
		window.location.href = url;
	});
	//回车搜索
	$(".search-input").keyup(function(e){
		if(e.keyCode === 13){
			$("#search").click();
			return false;
		}
	});
	//点击排序
	$('.list_sort').click(function(){
		var url = $(this).attr('url');
		var ids = $('.ids:checked');
		var param = '';
		if(ids.length > 0){
			var str = new Array();
			ids.each(function(){
				str.push($(this).val());
			});
			param = str.join(',');
		}

		if(url != undefined && url != ''){
			window.location.href = url + '/ids/' + param;
		}
	});
});
</script>

</body>
</html>