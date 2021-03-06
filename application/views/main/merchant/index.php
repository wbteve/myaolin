<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>商户中心</title>
    <link href="<?php echo base_url() ?>/ui/css/mobile/ylwx.css" rel="stylesheet"/>
    <script src="<?php echo base_url() ?>ui/js/main/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script type="text/javascript"></script>
</head>
<body style=" background: #f6f6f6;">
<div id="divLogout" style="margin-left: 5%; margin-top: 2%; border: 1px black dotted; cursor: pointer; text-align: center; background-color: #f2dede; width: 20%;"><a href="<?php echo (base_url() . 'merchant/logout') ?>">< 登出</a></div>
<div class="sh_con">
<?php if (!$hasDetail): ?>
    <em>您还未完善商户资料，请点击商户资料，完善后，可被激活。</em>
<?php endif; ?>
    <ul>
        <li>
<?php if ($merchantType == MerchantModel::TYPE_INDIVIDUAL): ?>
    <?php if ($hasDetail): ?>
            <a href="<?php echo base_url() ?>merchant/individualDetail">
                <img src="<?php echo base_url() ?>ui/img/mobile/sh_1.png" />
                <p>商户资料</p>
            </a>
    <?php else: ?>
            <a href="<?php echo base_url() ?>merchant/agreement">
                <img src="<?php echo base_url() ?>ui/img/mobile/sh_1.png" />
                <p>商户资料</p>
            </a>
    <?php endif; ?>
<?php elseif ($merchantType == MerchantModel::TYPE_COMPANY): ?>
    <?php if ($hasDetail): ?>
            <a href="<?php echo base_url() ?>merchant/companyDetail">
                <img src="<?php echo base_url() ?>ui/img/mobile/sh_1.png" />
                <p>商户资料</p>
            </a>
    <?php else: ?>
            <a href="<?php echo base_url() ?>merchant/agreement">
                <img src="<?php echo base_url() ?>ui/img/mobile/sh_1.png" />
                <p>商户资料</p>
            </a>
    <?php endif; ?>
<?php endif; ?>

        </li>
        <li>
            <a href="<?php echo base_url() ?>merchant/order">
                <img src="<?php echo base_url() ?>ui/img/mobile/sh_2.png" />
                <p>订单中心</p>
            </a>
        </li>
    </ul>
</div>
</body>
</html>
