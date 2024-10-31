<html>
<head>
  
  
  <style>
	.main-body{
		width:96%;
		margin:2%;
		float:left;
	}
	.main-body table {
		width: 100%;
		float: left;
		margin: 0;
		border-collapse: collapse;
	}
	.main-body table th {
		color: #fff;
		font-size: 0.95em;
		text-align: center;
		font-weight: 400;
		background: #023957;
		word-break: break-word;
		padding: 0.5%;
		width: auto;
		border-right: 1px solid #fff;
		margin: 0;
	}
	.main-body table td {
		text-align: center;
		font-weight: 400;
		word-break: break-word;
		font-size: 0.85em;
		padding: 0.5%;
		width: auto;
		border: 1px solid #999;
	}
	#table_pegination {
		float: left;
		margin: 0;
		width:100%;
	}
	.main-body .btn-info {
		width: 10% !important;
		float: right;
		margin: 0 0.3%;
		font-size: 1.1em;
		cursor: pointer;
		color: #fff;
		background-color: #c50e0e;
		border-color: #c50e0e;
		padding: 0.7%;
	}
	.main-body #pegination {
		width: 95% !important;
		border: 0 !important;
	}
  </style>
  
</head>
<body>

<div class="main-body">
	<table>
		<thead>
			<tr>
				<th>Fromname (Fromemail)</th>
				<th>To</th>
				<th>Reply To</th>
				<th>Subject</th>
				<th>Status</th>
				<th>Response</th>
				<th>Created At</th>
			</tr>
		</thead>
		<tbody id="fetchdata">
		</tbody>
		<tr>
		</tr>
	</table>
	<div id="table_pegination">
	<table border="0" cellpadding="0" cellspacing="0" id="paging-table" style="margin-top: 0;float: right;">
        <tbody>
			<tr>
				<form action="#" id="paginationform" name="paginationform" method="post"></form>							
				<td id="pegination">
						<a title="Previous Page" onclick="prevPegination()" class="btn btn-info">&lt; Prev</a>
						<input type="hidden" value="0" name="prev" id="prev">
						<a title="Next Page" onclick="nextPegination()" class="btn btn-info">Next &gt;</a>
						<input type="hidden" value="0" name="next" id="next">
				</td>
				<?php wp_nonce_field("pigeonmail_action_nonce"); ?>	
				<input type="hidden" value="0" name="page" id="page">
			   <td style="border:0;">
				  <select id="rowlist" name="rowlist" class="" style="margin: 0 15% !important;
					padding: 5px 0 !important;">
						<option value="50">50</option>											
						<option value="100">100</option>								
						<option value="100">500</option>								
						<option value="100">1000</option>								
						<option value="100">5000</option>								
					</select>
				</td>
				
			</tr>
        </tbody>
	</table>
</div>
<div>
</body>
</html>