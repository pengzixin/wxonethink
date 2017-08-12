<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
        <title>Bootstrap 101 Template</title>

        <!-- Bootstrap -->
        <link href="/Public/static/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/Public/static/static/css/style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            .main{margin-bottom: 60px;}
            .indexLabel{padding: 10px 0; margin: 10px 0 0; color: #fff;}
        </style>
    
    
</head>
<body>
<div class="main">

    <!--导航部分-->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid text-center">
            <div class="col-xs-3">
                <p class="navbar-text"><a href="index.html" class="navbar-link">首页</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">服务</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">发现</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">我的</a></p>
            </div>
        </div>
    </nav>
    <!--导航结束-->


		<div class="container-fluid container">
			<table class="table table-condensed table-hover table-striped">
				<tr>
					<th>问题</th>
					<th>报修时间</th>
					<th>状态</th>
				</tr>
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$repair): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($repair["trouble"]); ?></td>
						<td><?php echo (time_format($repair["create_time"])); ?></td>
						<td>
							<?php echo (get_status($repair["status"])); ?>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-info ajax-page" id="btn">获取更多数据~~~</button>
		</div>
	

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/Public/static/static/jquery-1.11.2.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/Public/static/static/bootstrap/js/bootstrap.min.js"></script>


<script type="text/javascript">

	var p = 0;
	var url = '/index.php?s=/Home/Repair/index';
	//var inner_url = '/wchat.php?s=/Repair/detail';
	$(function(){
		$('.ajax-page').click(function () {
			if($(this).hasClass('ajax-page')){
				p = p+1;
				$.getJSON(url+'/p/'+p,function(data){
					if(data['status']==1){
						list = data.page;
						html = '';

						for(index in list){
							html += '<tr><td>'+list[index].trouble+'</td>\
									<td>'+list[index].create_time+'</td>\
							<td>'+list[index].status+'</td></tr>';
						}
						//console.log(html);
						$("table").append(html);
						console.log($("table"))
					} else {
						$('.ajax-page').html("没有跟多数据了！！").removeClass('ajax-page')
					}
				})
			}
		});

	});

</script>

</div>
</body>
</html>