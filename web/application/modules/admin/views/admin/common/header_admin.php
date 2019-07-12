<!DOCTYPE html>
<html>
  <head>
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- jquery -->
		<script src="<?php echo ADMIN_PATH;?><?php echo $admin_lang;?>/js/jquery-2.2.4.min.js"></script>
    <script src="<?php echo ADMIN_PATH;?><?php echo $admin_lang;?>/js/jquery-ui.min.js"></script>
    <script src="/ckeditor/ckeditor.js?v=1"></script>
    <script src="/ckeditor/config.js?v=2323"></script>

	  <link href="<?php echo ADMIN_PATH;?>/<?php echo $admin_lang;?>/css/jquery-ui.css" rel="stylesheet">
    <link href="<?php echo ADMIN_PATH;?>/<?php echo $admin_lang;?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo ADMIN_PATH;?>/<?php echo $admin_lang;?>/css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- styles -->
		<link href="<?php echo ADMIN_PATH;?>/<?php echo $admin_lang;?>/css/styles.css" rel="stylesheet">
		<link href="<?php echo ADMIN_PATH;?>/<?php echo $admin_lang;?>/css/custom.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

<nav class="navbar navbar-inverse ">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/admin">Admin</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
        

				<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">주문정보 <span class="caret"></span></a>
          <ul class="dropdown-menu">
					  <li><a href="/admin/order/order_list">주문리스트</a></li>
            <li><a href="/admin/order/refund_list">환불리스트</a></li>
            <li><a href="/admin/movie/maker_list">무비 제작 리스트</a></li>
          </ul>
        </li>

				<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">상품 <span class="caret"></span></a>
          <ul class="dropdown-menu">
					  <li><a href="/admin/product/product_list">상품 리스트</a></li>
            <li><a href="/admin/product/product_hidden_list">비활성 상품 리스트</a></li>
            <li><a href="/admin/product/product_add">상품 등록</a></li>
            <li><a href="/admin/product/product_set_add">셋트 상품 등록</a></li>
            <li><a href="/admin/product/category_add">카테고리 등록</a></li>
          </ul>
        </li>

				<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">회원 <span class="caret"></span></a>
          <ul class="dropdown-menu">
						<li><a href="/admin/member/member_list">회원리스트</a></li>
            
          </ul>
        </li>

				<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">쿠폰 <span class="caret"></span></a>
          <ul class="dropdown-menu">					  
            <li><a href="/admin/coupon/coupon_form">쿠폰 생성</a></li>
            <li><a href="/admin/coupon/coupon_list">쿠폰 그룹 리스트</a></li>
            <li><a href="/admin/coupon/coupon_use_list">전체 쿠폰 리스트</a></li>
          </ul>
        </li>

				<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">협력업체 <span class="caret"></span></a>
          <ul class="dropdown-menu">
						<li><a href="/admin/partner/partner_list">협력업체 리스트</a></li>
            <li><a href="/admin/partner/partner_form">협력업체 등록</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">이벤트관리 <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/admin/conf/event_list">이벤트 리스트</a></li>
            <li><a href="/admin/conf/event_form">이벤트 생성</a></li>
            <li><a href="/admin/conf/event_win_list">당첨자 리스트</a></li>
          </ul>
        </li>

				<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">게시판 <span class="caret"></span></a>
          <ul class="dropdown-menu">						
            <li><a href="/admin/conf/one_one_list">1:1 질문 리스트</a></li>            
            <li><a href="/admin/conf/making_list">영상제작 배우기 리스트</a></li>
            <li><a href="/admin/conf/review_list">리뷰 리스트</a></li>
            <li><a href="/admin/conf/partner_offer_list">협력 요청</a></li>
          </ul>
        </li>
      </ul>
      <!-- form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form -->
      <ul class="nav navbar-nav navbar-right">
       
        

				<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">설정 <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/admin/conf/meta">Config</a></li>
            <li><a href="/admin/conf/files">files</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="/admin/logOut">로그아웃</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="page-content">
    	<div class="row">

	