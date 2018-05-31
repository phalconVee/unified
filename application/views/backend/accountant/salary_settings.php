
<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_salary_settings_add/');"
   class="btn btn-primary pull-right">
    <i class="entypo-plus-circled"></i>
    <?php echo get_phrase('add_new');?>
</a>

<br><br>
<table class="table table-bordered datatable" id="table_export">
    <thead>
    <tr>
        <th width="80"><div><?php echo get_phrase('sn');?></div></th>
        <th><div><?php echo get_phrase('staff_role');?></div></th>
        <th><div><?php echo get_phrase('employee_name');?></div></th>
        <th><div><?php echo get_phrase('pay_head');?></div></th>
        <th><div><?php echo get_phrase('unit');?>(&#x20A6;)</div></th>
        <th><div><?php echo get_phrase('type');?></div></th>
        <th><div><?php echo get_phrase('options');?></div></th>
    </tr>
    </thead>

    <tbody>
    <?php
    $salary_settings = $this->db->get('salary_settings' )->result_array();

    $i = 1;
    foreach($salary_settings as $row):?>
        <tr>
            <td><?php echo $i++;?></td>
            <td><?php echo $row['staff_type'];?></td>

            <?php
            if($row['staff_type'] == 'teacher'){
                ?>

                <td>
                    <?php
                    echo $this->db->get_where('teacher' , array(
                        'teacher_id' => $row['staff_id']
                    ))->row()->name;
                    ?>
                </td>

            <?php }elseif ($row['staff_type'] == 'accountant') {

                ?>

                <td>
                    <?php
                    echo $this->db->get_where('accountant' , array(
                        'accountant_id' => $row['staff_id']
                    ))->row()->name;
                    ?>
                </td>

            <?php

            }elseif($row['staff_type'] == 'librarian') {

                ?>

                <td>
                    <?php
                    echo $this->db->get_where('librarian' , array(
                        'librarian_id' => $row['staff_id']
                    ))->row()->name;
                    ?>
                </td>

            <?php

            }else { ?>

                <td>
                    <?php
                    echo $this->db->get_where('employee' , array(
                        'emp_id' => $row['staff_id']
                    ))->row()->name;
                    ?>
                </td>

            <?php } ?>
            <!--end staff type -->

            <td>
                <?php
                echo $this->db->get_where('pay_head' , array(
                    'pay_head_id' => $row['pay_head_id']
                ))->row()->pay_head_name;
                ?>
            </td>

            <td><?php echo number_format($row['unit'], 2);?></td>

            <td><?php echo $row['type'];?></td>

            <td>

                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                        <!-- teacher EDITING LINK -->
                        <li>
                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_salary_settings_edit/<?php echo $row['id'];?>');">
                                <i class="entypo-pencil"></i>
                                <?php echo get_phrase('edit');?>
                            </a>
                        </li>
                        <li class="divider"></li>

                        <!-- teacher DELETION LINK -->
                        <li>
                            <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?accountant/salarySettings/delete/<?php echo $row['id'];?>');">
                                <i class="entypo-trash"></i>
                                <?php echo get_phrase('delete');?>
                            </a>
                        </li>
                    </ul>
                </div>

            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        var datatable = $("#table_export").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oTableTools": {
                "aButtons": [

                    {
                        "sExtends": "xls",
                        "mColumns": [1,2]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [1,2]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText"	   : "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(0, false);
                            datatable.fnSetColumnVis(3, false);

                            this.fnPrint( true, oConfig );

                            window.print();

                            $(window).keyup(function(e) {
                                if (e.which == 27) {
                                    datatable.fnSetColumnVis(0, true);
                                    datatable.fnSetColumnVis(3, true);
                                }
                            });
                        }
                    }
                ]
            }

        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });

</script>

