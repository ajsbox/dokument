<div class="row-fluid">
	<?php $this->load->view('admin/admin-menu'); ?>
	<div class="span9">
		<div class="row-fluid">
			<h2>Total Stats</h2>
		</div>
		<div class="row-fluid" style="margin-bottom: 10px;">
			<!-- Graph HTML -->
<div id="graph-wrapper">
    <div class="graph-info">
        <a href="javascript:void(0)" class="visitors">Regular Registrations</a>
        <a href="javascript:void(0)" class="returning">Social Registrations</a>
    </div>
 
    <div class="graph-container">
        <div id="graph-lines"></div>
    </div>
</div>
<!-- end Graph HTML -->
		</div>
		<div class="row-fluid">
	<div class="span4">
		<div class="options-form" style="text-align: center;">
			<h4>Total Stats</h4>
			<p><strong>Registered Users :</strong> <?php echo $this->logik->stats('total_registered'); ?></p>
			<p><strong>Page Views :</strong> <?php echo $this->admin_model->total_hits(); ?></p>
			<p><strong>Facebook Users :</strong> <?php echo $this->logik->stats('total_fb'); ?></p>
			<p><strong>Twitter Users :</strong> <?php echo $this->logik->stats('total_tw'); ?></p>
		</div>
	</div>
	<div class="span4">
		<div class="options-form" style="text-align: center;">
			<h4>Most Active Users</h4>
			<?php foreach($this->admin_model->top_ten_users() as $top): ?>
			<p><strong><?php echo $top->username; ?> :</strong> <?php echo $this->admin_model->num_logins($top->username); ?></p>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="span4">
		<div class="options-form" style="text-align: center;">
			<h4>Most Active Pages</h4>
			<?php foreach($this->admin_model->top_ten_pages() as $page): ?>
			<p><strong><?php echo $this->admin_model->page_name_by_id($page->p_id); ?> :</strong> <?php echo $this->admin_model->num_p_views($page->p_id); ?></p>
			<?php endforeach; ?>
		</div>
		</div>
	</div> <!-- End total stats -->

	<div class="row-fluid">
		<div class="span5">
			<h2>Stats by Date</h2>
		</div>
		<div class="span5 offset2" style="margin-top: 15px;">
			<form class="form-inline" method="post" action="#" id="dateForm">
				<input type="text" name="start_date" id="startDate" class="input-small"> - 
				<input type="text" name="end_date" id="endDate" class="input-small">
				<input type="submit" id="datebtn" class="btn btn-primary" value="Load Stats">
			</form>
		</div>
	</div>

	<div class="row-fluid" style="text-align: center;">
		<div class="span4">
			<div class="options-form">
				<h4>Stats by Date</h4>
				<p class="emptyDate">Select a Date Range</p>
				<p><strong>Registered Users :</strong> <span id="total_users"></span></p>
				<p><strong>Page Views :</strong> <span id="total_hits"></span></p>
				<p><strong>Facebook Users :</strong> <span id="total_fb"></span></p>
				<p><strong>Twitter Users :</strong> <span id="total_tw"></span></p>
			</div>
		</div>
		<div class="span4">
			<div class="options-form" id="top_users">
				<h4>Top 10 Users by Date</h4>
				<p class="emptyDate">Select a Date Range</p>
			</div>
		</div>
		<div class="span4">
			<div class="options-form" id="top_pages">
				<h4>Top 10 Pages by Date</h4>
				<p class="emptyDate">Select a Date Range</p>
			</div>
		</div>
	</div>

	</div>
</div>
<script type="text/javascript">
var jsonData = $.ajax({
          url: default_url+"admin/graph_registrations",
          dataType:"json",
          async: false
          }).responseText;
$(document).ready(function(){


	var graphData = [{
        // Regular Registrations
        data: <?php echo $flot; ?>,
        //data: [ [2, 1300], [7, 1600], [8, 1900], [9, 2100], [10, 2500], [11, 2200], [12, 2000], [13, 1950], [14, 1900], [15, 2000] ],
        color: '#71c73e',
        points: { radius: 4, fillColor: '#71c73e' }
    }, { // Social registrations 
    	data: <?php echo $flot_social; ?>,
    	//data: [ [6, 500], [7, 600], [8, 550], [9, 600], [10, 800], [11, 900], [12, 800], [13, 850], [14, 830], [15, 1000] ], 
    	color: '#77b7c5', 
    	points: { radius: 4, fillColor: '#77b7c5' } 
    }
    ];

	// Lines
$.plot($('#graph-lines'), graphData, {
    series: {
        points: {
            show: true,
            radius: 1
        },
        lines: {
            show: true
        },
        shadowSize: 1
    },
    grid: {
    	show: true,
        color: '#646464',
        borderColor: 'transparent',
        borderWidth: 1,
        hoverable: true
    },
    xaxis: {
    	mode: 'time',
        tickColor: 'transparent',
        timeformat: "%m/%d/%y"
    },
    yaxis: {
        tickSize: 100,
        axisLabel: 'Registrations',
        tickDecimals: 0,
        min: 0
    }
});
 
var previousPoint = null;
 
$('#graph-lines').bind('plothover', function (event, pos, item) {
    if (item) {
        if (previousPoint != item.dataIndex) {
            previousPoint = item.dataIndex;
            $('#tooltip').remove();
            var x = item.datapoint[0],
                y = item.datapoint[1];
                date = new Date(x);
                showTooltip(item.pageX, item.pageY, y + ' Registrations on ' + date);
        }
    } else {
        $('#tooltip').remove();
        previousPoint = null;
    }
});

});
function showTooltip(x, y, contents) {
    $('<div id="tooltip">' + contents + '</div>').css({
        top: y - 16,
        left: x + 20
    }).appendTo('body').show('clip');
}
</script>