<script src="<?php echo Url::route('public/assets/js/table-manage-buttons.demo.min.js'); ?>"></script>
  
<legend class="m-t-10"><i class="fa fa-list-alt"></i> Remaining Stocks</legend>
<table id="data-table" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Barcode</th>
            <th>SKU ID</th>
            <th>Price</th>
            <th>Quanity</th>
        </tr>
    </thead>
    <tbody>
        <tr class="odd gradeX">
            <td>Trident</td>
            <td>Internet Explorer 4.0</td>
            <td>Win 95+</td>
            <td>4</td>
            <td>X</td>
        </tr>
    </tbody>
</table>


<script>
    $(document).ready(function() {
        App.init();
        TableManageButtons.init();
    });
</script>