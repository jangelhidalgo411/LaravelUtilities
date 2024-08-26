@extends('Layouts.MainLayout')

@section('CustomStyles')
<link href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css" rel="stylesheet" />
@if($custonCSS !== '')
<link href="/css/{{$custonCSS}}.css" rel="stylesheet" />
@endif
<style type="text/css">

table {
    font-size: 1rem;
}

table th,
table td {
    text-align: left;
}

table th[colspan="2"] {
    text-align: center;
}

</style>
@endsection

@section('CustomScripts')
<script type="text/javascript" src="//cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		new DataTable('#DataTable', {
			ajax: {
				url: '{{ $TableURL }}',
				type: 'POST'
			},
			order: [[0, 'asc']],
			columns: [
				{!! $TableColumns !!}
			]
		});
	});

	function ShowInfo(title,url) {
		$.get(url, function(data, status){
			Swal.fire({
				title: title,
				html: data,
				showConfirmButton: false,
				showCloseButton: true,
				allowOutsideClick: false,
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					popup: 'animate__animated animate__fadeOutUp'
				},
				width: '60%',
				padding: '1em'
			});
		});
	}
</script>
@endsection

@section('content')
<div class="container p-0 m-auto">
	<table id="DataTable" class="display compact" style="width:100%">
		<thead>
			<tr>
				@foreach($TableHeaders as $Header)
					<th>{{ $Header }}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>

		</tbody>
		<tfoot>
			<tr>
				@foreach($TableHeaders as $Header)
					<th>{{ $Header }}</th>
				@endforeach
			</tr>
		</tfoot>
	</table>
</div>
@endsection