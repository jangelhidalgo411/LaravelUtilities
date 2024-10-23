@extends('Layouts.MainLayout')

@section('Favicon')
	<link rel="icon" type="image/x-icon" href="/img/favicons/{{$Favicon}}">
@endsection

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

	.select2-container {
		width: 100% !important;
	}

	.select2-results__option {
		text-transform: capitalize;
	}

	.Filters {
		display: grid;
		gap: 1rem;
		grid-template-columns: auto auto auto auto;
	}

	tr td button {
		-webkit-text-fill-color: #FFFFFF;
		font-weight: bold !important;
	}
	</style>
@endsection

@section('CustomScripts')
	<script type="text/javascript" src="//cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('.filter').select2();

			var DT = new DataTable('#DataTable', {
				deferRender: true,
				ajax: {
					url: '{{ $TableURL }}',
					data: function (d) {
						filters = {};

						$('.filter').each(function(){
							filters[$(this).attr('data-col')] = $(this).val();	
						});

						d.filters = filters;
					},
					type: 'POST'
				},
				order: [[0, 'asc']],
				columns: [
					{!! $TableColumns !!},
					{
						data: null,
						orderable: false,
						render: function ( data, type, row ) {
							var Link = '{{$Page}}/'+row.{{$TableID}};
							Link = Link.replace("\'", "\\\'");

						  return '<button type="button" class="btn btn-primary newWinLink" onclick="openLink(\''+Link+'\');"><i class="fa-solid fa-magnifying-glass"></i></button>'
						},
						visible: true
					}
				],
				createdRow: function ( row, data, index ) {
					row.classList.add('Pokemon_Type');
					row.classList.add(data.Pokemon_Type);
				},
				//pageNumber: 1,
				//totalPages: 4,
				serverSide: true,
				processing: true,
				autoWidth: true,
				lengthMenu: [
					[ 10, 25, 50, 100, 250, 1000, 2500, 50000], 
					[ 10, 25, 50, 100, 250, 1000, 2500, 'ALL']
				],
				pageLength: 10,
			});

			$('.filter').on('change', function () {
				DT.draw(); // Redraw DataTable wher filter change
			});

			$('.btn-refresh').click(function() {
				DT.ajax.reload();
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

		/* Open Link On new windows */
		function openLink(link) {
			window.open(link, 'summarywindow', 'menubar=no,toolbar=no,scrollbars=1,resizable=yes,location=no,status=no,width=1095,height=780');
		}
	</script>
@endsection

@section('content')
<div class="col-11 p-0 m-auto">
	<div class="Filters">
		@foreach($TableFilters as $KFilter => $Filter)
			@if(count($Filter['Options'])>0)
				<div class="col TableFilters">
					<label class="col-12">{{ $Filter['FilterCaption'] }}</label>
					<div class="col-12">
						<select class="filter" data-col="{{ $KFilter }}" multiple>
							@foreach($Filter['Options'] as $KOption => $Option)
								<option value="{{ $Option->Value }}">{{ $Option->Caption }}</option>
							@endforeach
						</select>
					</div>
				</div>
	        @endif
		@endforeach		
	</div>	

	<div class="col-12">
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

	<div class="footer-buttons">
		<button type="button" class="btn btn-primary btn-refresh">Refresh</button>
	</div>
</div>
@endsection