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
            

            
	
	<div class="data-table table-striped">
            <table>
      
                <tbody>
                    <tr>
                        <td >
                            <div style="height:400px; overflow:scroll;">
                            <table class="my-table" border="0" cellspacing="1" cellpadding="1">
                                <caption align="top">Performance</caption>  
                                <thead>
                                    <tr>
                                        <th>
                                            <select name="pd_key">
                                                <option value='<?php echo U("",array_diff_key (I(""),array("pd_key"=>0)));?>'>KPI_Period</option>
                                                <?php if(is_array($departmentSelect1)): $i = 0; $__LIST__ = $departmentSelect1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php if(($_GET['pd_key']) == $vo[pd]): ?>selected<?php endif; ?>  value='<?php echo U("",array_merge(I(""),array("pd_key"=>"$vo[pd]")));?>'><?php echo ($vo["pd"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                            <?php if(($_GET['kpiOrder1']) == "1"): ?><a href="<?php echo U('',array_merge(I(''),array('kpiOrder1'=>2)));?>">↓</a><?php else: ?><a href="<?php echo U('',array_merge(I(''),array('kpiOrder1'=>1)));?>">↑</a><?php endif; ?></th>
                                        <th>
                                            <select name="md_key">
                                                <option value='<?php echo U("",array_diff_key (I(""),array("md_key"=>0)));?>'>Company_Name|Department_Name</option>
                                                <?php if(is_array($departmentSelect)): $i = 0; $__LIST__ = $departmentSelect;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $test=$vo[company_id]."-".$vo[deparment_id]; ?>
                                                    <option <?php if(($_GET['md_key']) == $test): ?>selected<?php endif; ?>  value='<?php echo U("",array_merge(I(""),array("md_key"=>"$vo[company_id]-$vo[deparment_id]")));?>'><?php echo ($vo["company_name"]); ?> | <?php echo ($vo["department_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                            </th>
                                        <th>(Top) KPI</th>
                                        <th>(Bottom) KPI</th>
                                        <th>(Avg) KPI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php if(is_array($departmentInfo)): $i = 0; $__LIST__ = $departmentInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                            <td><?php echo ($vo["period"]); ?></td>
                                            <td><?php echo ($vo["company"]); ?> | <?php echo ($vo["department"]); ?></td>
                                            <td><?php echo ($vo["max"]); ?></td>
                                            <td><?php echo ($vo["min"]); ?></td>
                                            <td><?php echo ($vo["avg"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                            </div>
                        </td>
                        <td>
                              <table class="my-table" border="0" cellspacing="1" cellpadding="1">
                                <caption align="top">Company Info</caption>  
                                
                                <thead>
                                    <tr>
                                        <th>KPI_Period</th>
                                        <th>Company_Name</th>
                                        <th>(Top) KPI</th>
                                        <th>(Bottom) KPI</th>
                                        <th>(Avg) KPI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php if(is_array($companyInfo)): $i = 0; $__LIST__ = $companyInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                            <td><?php echo ($vo["period"]); ?></td>
                                            <td><?php echo ($vo["company"]); ?></td>
                                            <td><?php echo ($vo["max"]); ?></td>
                                            <td><?php echo ($vo["min"]); ?></td>
                                            <td><?php echo ($vo["avg"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="height:400px; overflow:scroll;">
                            <table>
                                <caption align="top">Cost</caption>  
                                
                                <thead>
                                    <tr>
                                        <th>
                                            <select name="salary_pd">
                                                <option value='<?php echo U("",array_diff_key (I(""),array("salary_pd"=>0)));?>'>KPI_Period</option>
                                                <?php if(is_array($departmentSelect1)): $i = 0; $__LIST__ = $departmentSelect1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php if(($_GET['salary_pd']) == $vo[pd]): ?>selected<?php endif; ?>  value='<?php echo U("",array_merge(I(""),array("salary_pd"=>$vo[pd])));?>'><?php echo ($vo["pd"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </th>
                                        <th>Company_Name|Department_Name</th>
                                        <th>(Total) Salary</th>
                                        <th>(Top) Salary</th>
                                        <th>(Bottom) Salary</th>
                                        <th>(Avg) Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php if(is_array($salary)): $i = 0; $__LIST__ = $salary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                            <td><?php echo ($vo["period"]); ?></td>
                                            <td><?php echo ($vo["company"]); ?> | <?php echo ($vo["department"]); ?></td>
                                            <td><?php echo ($vo["sum"]); ?></td>
                                            <td><?php echo ($vo["max"]); ?></td>
                                            <td><?php echo ($vo["min"]); ?></td>
                                            <td><?php echo ($vo["avg"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                            </dvv>
                        </td> 
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="data-table table-striped">
		<table>
			<thead>
				<tr>
					
					<th>Talent_ID</th>
					<th>Status
                                            <select name="is_employee">
                                                <option value="<?php echo U('',array_diff_key(I(''),array('is_employee'=>0)));?>">is_employee</option>
                                                <option <?php if(($_GET['is_employee']) == "1"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('is_employee'=>1)));?>">Employee</option>
                                                <option <?php if(($_GET['is_employee']) == "2"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('is_employee'=>2)));?>">unEmployee</option>
                                            </select>
                                        </th>
					<th>L_Name</th>
					<th>M_Name</th>
					<th>F_Name</th>
					<th>SSN</th>
					<th>Gender</th>
					<th>DoB</th>
					<th>University_Name</th>
					<th>
                                            <select name="degree_list">
                                                <option value="<?php echo U('',array_diff_key(I(''),array('degree_list'=>'')));?>">Degree</option>
                                            <?php $_result=C("DEGREE");if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php if(((isset($_GET['degree_list']) && ($_GET['degree_list'] !== ""))?($_GET['degree_list']):"999") == $key): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('degree_list'=>$key)));?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </th>
					<th>GPA</th>
					<th>
                                            <select name="position_list">
                                                <option value="<?php echo U('',array_diff_key(I(''),array('position_list'=>0)));?>">Position_Name</option>
                                            <?php if(is_array($positionSelect)): $i = 0; $__LIST__ = $positionSelect;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php if(($_GET['position_list']) == $vo["position_id"]): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('position_list'=>$vo["position_id"])));?>"><?php echo ($vo["position_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </th>
					<th>
                                            <select name="sid_list">
                                                <option value="<?php echo U('',array_diff_key(I(''),array('sid_list'=>'')));?>">Skill_Name</option>
                                            <?php if(is_array($sidSelect)): $i = 0; $__LIST__ = $sidSelect;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option <?php if(($_GET['sid_list']) == $vo["skill_id"]): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('sid_list'=>$vo["skill_id"])));?>"><?php echo ($vo["skill_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                            
                                            
                                                 <select name="sscore_list">
                                                <option value="<?php echo U('',array_diff_key(I(''),array('sscore_list'=>0)));?>">Skill_Score</option>
                                                <option <?php if(($_GET['sscore_list']) == "1"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('sscore_list'=>1)));?>">0-20</option>
                                                <option <?php if(($_GET['sscore_list']) == "2"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('sscore_list'=>2)));?>">20-40</option>
                                                <option <?php if(($_GET['sscore_list']) == "3"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('sscore_list'=>3)));?>">40-60</option>
                                                <option <?php if(($_GET['sscore_list']) == "4"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('sscore_list'=>4)));?>">60-80</option>
                                                <option <?php if(($_GET['sscore_list']) == "5"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('sscore_list'=>5)));?>">80-100</option>
                                            </select>
                                        </th>
					<th>
                                            <select name="xp_list">
                                                <option value="<?php echo U('',array_diff_key(I(''),array('xp_list'=>0)));?>">XP</option>
                                                <option <?php if(($_GET['xp_list']) == "1"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('xp_list'=>1)));?>">0-200</option>
                                                <option <?php if(($_GET['xp_list']) == "2"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('xp_list'=>2)));?>">201-400</option>
                                                <option <?php if(($_GET['xp_list']) == "3"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('xp_list'=>3)));?>">401-600</option>
                                                <option <?php if(($_GET['xp_list']) == "4"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('xp_list'=>4)));?>">601-800</option>
                                                <option <?php if(($_GET['xp_list']) == "5"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('xp_list'=>5)));?>">801-1000</option>
                                            </select>
                                        </th>
					<th>
                                            <select name="level_list">
                                                <option value="<?php echo U('',array_diff_key(I(''),array('level_list'=>0)));?>">Level</option>
                                                <option <?php if(($_GET['level_list']) == "1"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('level_list'=>1)));?>">0-20</option>
                                                <option <?php if(($_GET['level_list']) == "2"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('level_list'=>2)));?>">20-40</option>
                                                <option <?php if(($_GET['level_list']) == "3"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('level_list'=>3)));?>">40-60</option>
                                                <option <?php if(($_GET['level_list']) == "4"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('level_list'=>4)));?>">60-80</option>
                                                <option <?php if(($_GET['level_list']) == "5"): ?>selected<?php endif; ?>  value="<?php echo U('',array_merge(I(''),array('level_list'=>5)));?>">80-100</option>
                                            </select>
                                        </th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$config): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($config["talent_id"]); ?></td>
						<td><?php echo ($config["status_text"]); ?></td>
						<td><?php echo ($config["l_name"]); ?></td>
						<td><?php echo ($config["m_name"]); ?></td>
						<td><?php echo ($config["f_name"]); ?></td>
						<td><?php echo ($config["ssn"]); ?></td>
						<td><?php echo ($config["gender_text"]); ?></td>
						<td><?php echo ($config["dob"]); ?></td>
						<td><?php echo ($config["university_name"]); ?></td>
						<td><?php echo ($config["degree_text"]); ?></td>
						<td><?php echo ($config["gpa"]); ?></td>
						<td><?php echo ((isset($config["position_name"]) && ($config["position_name"] !== ""))?($config["position_name"]):'none'); ?></td>
                                        
						<td><?php echo get_skill($config["talent_id"]);?></td>
						<td><?php echo ($config["xp"]); ?></td>
						<td><?php echo ($config["level"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php else: ?>
				<td colspan="6" class="text-center"> aOh! 暂时还没有内容! </td><?php endif; ?>
			</tbody>
		</table>
		<!-- 分页 -->
	    <div class="page">
	        <?php echo ($_page); ?>
	    </div>
	</div>
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