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
                                <caption align="top">Training History</caption>  
                                 <thead>
                                    <tr>
                                        <th>T_End_Date<?php if(($_GET['trainingOrder1']) == "1"): ?><a href="<?php echo U('',array('trainingOrder1'=>2));?>">↓</a><?php else: ?><a href="<?php echo U('',array('trainingOrder1'=>1));?>">↑</a><?php endif; ?></th>
                                        <th>Training_Name</th>
                                        <th>
                                            <select name="Skill_Name">
                                                <option value="<?php echo U('');?>">Skill_Name</option>
                                                <?php if(is_array($trainingSelect1)): $i = 0; $__LIST__ = $trainingSelect1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php if(($_GET['skill_id']) == $vo["skill_id"]): ?>selected<?php endif; ?> value="<?php echo U('',array('skill_id'=>$vo['skill_id']));?>"><?php echo ($vo['skill_name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </th>
                                        <th>T_Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php if(is_array($training)): $i = 0; $__LIST__ = $training;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                            <td><?php echo ($vo["end_date"]); ?></td>
                                            <td><?php echo ($vo["training_name"]); ?></td>
                                            <td><?php echo ($vo["skill_name"]); ?></td>
                                            <td><?php echo ($vo["t_grade"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </td>
                        <td>
                              <table class="my-table" border="0" cellspacing="1" cellpadding="1">
                                <caption align="top">KPI & Salary History</caption>  
                                <tbody>
                                    <tr>
                                        <td>
                                            <div id='mykpi' style="height: 400px;width: 800px">1</div>
                                            <div id='mykpi1' style="height: 400px;width: 800px">1</div>
                                            <script type="text/javascript">
                                                var myChart = echarts.init(document.getElementById('mykpi1'));
                                                
                                                option1 = {
   
                                                            tooltip: {
                                                                trigger: 'item',
                                                                formatter: '{a} <br/>{b} : {c}'
                                                            },
                                                            legend: {
                                                                left: 'left',
                                                                data: ['KPI Score', 'salary rank in company', 'salary rank in backbone','Score rank in company', 'Score rank in backbone']
                                                            },
                                                            xAxis: {
                                                                type: 'category',
                                                                name: 'x',
                                                                splitLine: {show: false},
                                                                data: [ <?php if(is_array($salary)): $i = 0; $__LIST__ = $salary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($vo["kpi_period"]); ?>',<?php endforeach; endif; else: echo "" ;endif; ?> ]
                                                            },
                                                            grid: {
                                                                left: '3%',
                                                                right: '4%',
                                                                bottom: '3%',
                                                                containLabel: true
                                                            },
                                                            yAxis: [{
                                                                type: 'value',
                                                                name: '排名',
                                                                min: 0,
                                                                max: 100,
                                                                interval: 5,
                                                                axisLabel: {
                                                                    formatter: '{value} %'
                                                                }
                                                            },
                                                                {
                                                                    type: 'value',
                                                                    name: 'Score',
                                                                    min: 0,
                                                                    max: 100,
                                                                    interval: 5,
                                                                    axisLabel: {
                                                                        formatter: '{value} '
                                                                    }
                                                                }
                                                        ],
                                                            series: [
                                                                {
                                                                    name: 'KPI Score',
                                                                    type: 'line',
                                                                    data: [<?php if(is_array($salary)): $i = 0; $__LIST__ = $salary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($vo["score"]); ?>',<?php endforeach; endif; else: echo "" ;endif; ?>]
                                                                },
                                                                {
                                                                    name: 'salary rank in company',
                                                                    type: 'line',
                                                                    data: [<?php if(is_array($salary)): $i = 0; $__LIST__ = $salary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($vo["rank_c"]); ?>',<?php endforeach; endif; else: echo "" ;endif; ?>]
                                                                },
                                                                {
                                                                    name: 'salary rank in backbone',
                                                                    type: 'line',
                                                                    data: [<?php if(is_array($salary)): $i = 0; $__LIST__ = $salary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($vo["rank_b"]); ?>',<?php endforeach; endif; else: echo "" ;endif; ?>]
                                                                },
                                                                {
                                                                    name: 'Score rank in company',
                                                                    type: 'line',
                                                                    data: [<?php if(is_array($salary)): $i = 0; $__LIST__ = $salary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($vo["rank_c_1"]); ?>',<?php endforeach; endif; else: echo "" ;endif; ?>]
                                                                },
                                                                {
                                                                    name: 'Score rank in backbone',
                                                                    type: 'line',
                                                                    data: [<?php if(is_array($salary)): $i = 0; $__LIST__ = $salary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($vo["rank_b_1"]); ?>',<?php endforeach; endif; else: echo "" ;endif; ?>]
                                                                }
                                                            ]
                                                        };
                                                    myChart.setOption(option1);
                                                    // 基于准备好的dom，初始化echarts实例
                                                    var myChart = echarts.init(document.getElementById('mykpi'));

                                                    // 指定图表的配置项和数据
                                                    
                                                        option = {
                                                            tooltip: {
                                                                trigger: 'axis'
                                                            },
                                                            legend: {
                                                                data:['Score','Base_Salary','bonus']
                                                            },
                                                            xAxis: [
                                                                {
                                                                    type: 'category',
                                                                   
                                                                    data: [ <?php if(is_array($salary)): $i = 0; $__LIST__ = $salary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($vo["kpi_period"]); ?>',<?php endforeach; endif; else: echo "" ;endif; ?> ]
                                                                }
                                                            ],
                                                            yAxis: [
                                                                {
                                                                    type: 'value',
                                                                    name: 'money',
                                                                    min: 0,
                                                                    max: 100000,
                                                                    interval: 5000,
                                                                    axisLabel: {
                                                                        formatter: '{value} $'
                                                                    }
                                                                },
                                                                {
                                                                    type: 'value',
                                                                    name: 'Score',
                                                                    min: 0,
                                                                    max: 100,
                                                                    interval: 5,
                                                                    axisLabel: {
                                                                        formatter: '{value} '
                                                                    }
                                                                }
                                                            ],
                                                            series: [
                                                                {
                                                                    name:'Base_Salary',
                                                                    type:'bar',
                                                                    data:[ <?php if(is_array($salary)): $i = 0; $__LIST__ = $salary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($vo["base_salary"]); ?>',<?php endforeach; endif; else: echo "" ;endif; ?>]
                                                                },
                                                                {
                                                                    name:'bonus',
                                                                    type:'bar',
                                                                    data:[ <?php if(is_array($salary)): $i = 0; $__LIST__ = $salary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($vo["bonus"]); ?>',<?php endforeach; endif; else: echo "" ;endif; ?>]
                                                                },
                                                                {
                                                                    name:'Score',
                                                                    type:'line',
                                                                    yAxisIndex: 1,
                                                                    data:[ <?php if(is_array($salary)): $i = 0; $__LIST__ = $salary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($vo["score"]); ?>',<?php endforeach; endif; else: echo "" ;endif; ?>]
                                                                }
                                                            ]
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
                            <table>
                                <caption align="top">Project History</caption>  
                                
                                <thead>
                                    <tr>
                                        <th>P_End_Date<?php if(($_GET['date_project']) == "1"): ?><a href="<?php echo U('',array_merge(I(''),array('date_project'=>2)));?>">↓</a><?php else: ?><a href="<?php echo U('',array_merge(I(''),array('date_project'=>1)));?>">↑</a><?php endif; ?></th>
                                        <th>Project_Name</th>
                                        <th>
                                             <select name="skill_project">
                                                <option value='<?php echo U("",array_diff_key (I(""),array("skill_project"=>0)));?>'>Skill_Name</option>
                                                <?php if(is_array($trainingSelect1)): $i = 0; $__LIST__ = $trainingSelect1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php if(($_GET['skill_project']) == $vo[skill_id]): ?>selected<?php endif; ?>  value='<?php echo U("",array_merge(I(""),array("skill_project"=>"$vo[skill_id]")));?>'><?php echo ($vo["skill_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </th>
                                        <th>P_Grade</th>
                                        <th>Quality</th>
                                        <th>Pro_Mgr_Name</th>
<!--                                        <th>Skill_Score<?php if(($_GET['skillOrder1']) == "1"): ?><a href="<?php echo U('',array('skillOrder1'=>2));?>">↓</a><?php else: ?><a href="<?php echo U('',array('skillOrder1'=>1));?>">↑</a><?php endif; ?></th>
                                        <th>Rank<?php if(($_GET['skillOrder1']) == "3"): ?><a href="<?php echo U('',array('skillOrder1'=>4));?>">↓</a><?php else: ?><a href="<?php echo U('',array('skillOrder1'=>3));?>">↑</a><?php endif; ?></th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php if(is_array($project)): $i = 0; $__LIST__ = $project;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                            <td><?php echo ($vo["end_date"]); ?></td>
                                            <td><?php echo ($vo["project_name"]); ?></td>
                                            <td><?php echo ($vo["skill_name"]); ?></td>
                                            <td><?php echo ($vo["p_grade"]); ?></td>
                                            <td><?php echo ($vo["quality"]); ?></td>
                                            <td><?php echo ($vo["f_name"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </td> 
                        <td>
                            <div id='skill' style="height: 400px;width: 1000px"></div>
                                     <script type="text/javascript">
                                                
                                                    // 基于准备好的dom，初始化echarts实例
                                                    var myChart = echarts.init(document.getElementById('skill'));

                                                    // 指定图表的配置项和数据
                                                    
                                                        option = {
                                                            tooltip: {
                                                                trigger: 'axis'
                                                            },
                                                            legend: {
                                                                data:[ <?php if(is_array($add)): $i = 0; $__LIST__ = $add;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($key); ?>',<?php endforeach; endif; else: echo "" ;endif; ?> ]
                                                            },
                                                            xAxis: [
                                                                {
                                                                    type: 'category',
                                                                   
                                                                    data: [ <?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($key); ?>',<?php endforeach; endif; else: echo "" ;endif; ?> ]
                                                                }
                                                            ],
                                                            yAxis: [
                                                                {
                                                                    type: 'value',
                                                                    name: 'Skill_Score',
                                                                    min: 0,
                                                                    max: 100,
                                                                    interval: 5,
                                                                    axisLabel: {
                                                                        formatter: '{value}'
                                                                    }
                                                                },
                                                            ],
                                                            series: [
                                                                <?php if(is_array($add)): $i = 0; $__LIST__ = $add;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>{
                                                                    name:'<?php echo ($key); ?>',
                                                            <?php $key1 = $key; ?>
                                                                    type:'line',
                                                                    data:[ <?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>'<?php echo ($vo[$key1]); ?>',<?php endforeach; endif; else: echo "" ;endif; ?>]
                                                                },<?php endforeach; endif; else: echo "" ;endif; ?>
                                                            ]
                                                        };


                                                    // 使用刚指定的配置项和数据显示图表。
                                                    myChart.setOption(option);
                                                </script>                               
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
        $('select').on('change',function(){
            window.location.href=this.value;
        })
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