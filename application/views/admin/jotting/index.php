<div id="content" class="col-lg-10 col-sm-10">
    <div>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>admin/jotting">随记</a>
            </li>
            <li>
                <a href="javascript:void(0);">随记列表</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div class="box-header well">
                    <h2><i class="glyphicon glyphicon-qrcode"></i>&nbsp;随记列表</h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <form role="form" id="frmContent" method="GET" action="<?php echo base_url() . 'admin/jotting' ?>">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtKeyword" placeholder="搜索" value="<?php echo $keyword ?>">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success" id="aSearch">
                                    <i class="glyphicon glyphicon-search icon-white"></i>
                                    搜索
                                </button>
                            </div>
                        </form>
<!--                        <div class="col-md-4">-->
<!--                            <a class="btn btn-warning pull-right" href="--><?php //echo base_url(); ?><!--admin/jotting/edit">-->
<!--                                <i class="glyphicon glyphicon-plus icon-white"></i>-->
<!--                                添加-->
<!--                            </a>-->
<!--                        </div>-->
                    </div>
                    <hr />
                    <?php if (count($jottings) > 0): ?>
                        <div class="pull-right"><?php echo '共: ' . $count . ' 条数据'?></div>
                        <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>标题</th>
                                <th>状态</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($jottings as $jotting): ?>
                                <tr>
                                    <th><?php echo $jotting['jottingId'] ?></th>
                                    <td><?php echo $jotting['jottingTitle'] ?></td>
                                    <td class="center">
                                        <?php if ($jotting['jottingStatus'] == \util\Constant::STATUS_ACTIVE): ?>
                                            <span class="label-info label label-default">激活</span>
                                        <?php else: ?>
                                            <span class="label-warning label label-default">未激活</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="center">
                                        <a class="btn btn-primary" href="<?php echo base_url();?>admin/jotting/edit/<?php echo $jotting['jottingId'] ?>">
                                            <i class="glyphicon glyphicon-edit icon-white"></i>
                                            编辑
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <ul class="pagination pagination-centered">
                            <li><a href="<?php echo (base_url() . 'admin/jotting/1') ?>">首页</a></li>
                            <?php if ($previous): ?>
                                <li><a href="<?php echo (base_url() . 'admin/jotting/' . $previous) ?>">上页</a></li>
                            <?php endif; ?>
                            <?php if ($totalPageNumber == 1): ?>
                                <li><a href="<?php echo (base_url() . 'admin/jotting/1') ?>">1</a></li>
                            <?php endif; ?>
                            <?php if ($totalPageNumber == 2): ?>
                                <li><a href="<?php echo (base_url() . 'admin/jotting/1') ?>">1</a></li>
                                <li><a href="<?php echo (base_url() . 'admin/jotting/2') ?>">2</a></li>
                            <?php endif; ?>
                            <?php if ($totalPageNumber > 2): ?>
                                <?php if ($currentPageNumber == 1): ?>
                                    <li><a href="<?php echo (base_url() . 'admin/jotting/' . ($currentPageNumber)) ?>"><?php echo ($currentPageNumber); ?></a></li>
                                    <li><a href="<?php echo (base_url() . 'admin/jotting/' . ($currentPageNumber + 1)) ?>"><?php echo ($currentPageNumber + 1); ?></a></li>
                                    <li><a href="<?php echo (base_url() . 'admin/jotting/' . ($currentPageNumber + 2)) ?>"><?php echo ($currentPageNumber + 2); ?></a></li>
                                <?php else: ?>
                                    <?php if ($currentPageNumber + 1 == $totalPageNumber): ?>
                                        <li><a href="<?php echo (base_url() . 'admin/jotting/' . ($currentPageNumber - 1)) ?>"><?php echo ($currentPageNumber - 1); ?></a></li>
                                        <li><a href="<?php echo (base_url() . 'admin/jotting/' . $currentPageNumber) ?>"><?php echo ($currentPageNumber); ?></a></li>
                                        <li><a href="<?php echo (base_url() . 'admin/jotting/' . $totalPageNumber) ?>"><?php echo $totalPageNumber; ?></a></li>
                                    <?php elseif($currentPageNumber == $totalPageNumber): ?>
                                        <li><a href="<?php echo (base_url() . 'admin/jotting/' . ($currentPageNumber - 2)) ?>"><?php echo ($currentPageNumber - 2); ?></a></li>
                                        <li><a href="<?php echo (base_url() . 'admin/jotting/' . ($currentPageNumber - 1)) ?>"><?php echo ($currentPageNumber - 1); ?></a></li>
                                        <li><a href="<?php echo (base_url() . 'admin/jotting/' . $totalPageNumber) ?>"><?php echo $totalPageNumber; ?></a></li>
                                    <?php else: ?>
                                        <li><a href="<?php echo (base_url() . 'admin/jotting/' . ($currentPageNumber - 1)) ?>"><?php echo ($currentPageNumber - 1); ?></a></li>
                                        <li><a href="<?php echo (base_url() . 'admin/jotting/' . ($currentPageNumber)) ?>"><?php echo ($currentPageNumber); ?></a></li>
                                        <li><a href="<?php echo (base_url() . 'admin/jotting/' . ($currentPageNumber + 1)) ?>"><?php echo ($currentPageNumber + 1); ?></a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($next): ?>
                                <li><a href="<?php echo (base_url() . 'admin/jotting/' . $next) ?>">下页</a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo (base_url() . 'admin/jotting/' . $totalPageNumber) ?>">末页</a></li>
                        </ul>
                    <?php else: ?>
                        暂无数据
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image_upload_preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function() {
        $("#inputFile").change(function() {
            readURL(this);
        });

        $('#aSearch').click(function() {
            var frm = document.getElementById('frmContent');
            var keyword = $('#txtKeyword').val();

            if (keyword) {
                frm.action = '<?php echo (base_url() . 'admin/jotting/1/')?>' + keyword;
                frm.submit();
            }
        });

        $('.box-content ul>li>a').click(function() {
            var url = $(this).attr('href');
            var keyword = $('#txtKeyword').val();

            if (keyword) {
                $(this).attr('href', url + '/' + keyword);
            }
        });
    });
</script>
