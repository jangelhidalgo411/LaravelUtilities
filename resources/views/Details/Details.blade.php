@extends('Layouts.MainLayout')

@section('CustomStyles')
	<link href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css" rel="stylesheet" />
	@if($custonCSS !== '')
	<link href="/css/{{$custonCSS}}.css" rel="stylesheet" />
	@endif
	<style type="text/css">

		.card {
			border: .5rem solid;
		}

		.card-header {
			border-bottom: .25rem solid;
		}
		.card-footer {
			border-top: .25rem solid;
			max-height: 20rem;
		}

		.table-bordered>:not(caption)>* {
			border-width: .2rem 0;
		}

		.table-bordered>:not(caption)>*>* {
			border-width: 0 .2rem;
		}
		.nav-link:not(.active) {
			color: #000000 !important;
			-webkit-text-fill-color: #000000 !important;
		}

		.nav-link.active {
		    font-weight: bold;
		}

		.d-Inline th,
		.d-Inline td {
			width: 50%;
		}

		#Sets th {
			text-transform: uppercase !important;
		}

		#Sets td {
			text-transform: capitalize !important;
		}


	</style>
@endsection

@section('CustomScripts')
	<script type="text/javascript" src="//cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
	<script type="text/javascript">

		@if(isset($Data->Sets->Items) && count((array)$Data->Sets->Items) > 0 )
			$(document).ready(function() {
				var DT = new DataTable('#Sets', {
					data: {!! json_encode($Data->Sets->Items) !!},
					deferRender: true,
					order: [[0, 'asc']],
					serverSide: false,
					processing: true,
					autoWidth: true,
					lengthMenu: [
						[ 10, 25, 50, 100, 250, 1000, 2500, 50000], 
						[ 10, 25, 50, 100, 250, 1000, 2500, 'ALL']
					],
					pageLength: 10
				});
			});
		@endif


	</script>
@endsection

@section('content')
<div class="container p-0 m-auto">
	<div class="card mb-3 border-{{ $Data->Color }}">
		<div class="card-header border-{{ $Data->Color }} bg-transparent text-center p-0">
			<h1 class="text-capitalize {{ $Data->Color }}">{{ $Data->Name }}</h1>
			<div>
				<ul class="nav nav-tabs card-header-tabs mx-0" id="myTab" role="tablist">
					@foreach($Data->Images->Tabs as $key => $Tab)
					<li class="nav-item">
						<a class="nav-link @if($key < 1) active @endif {{ $Data->Color }}" id="{{$Tab}}-tab" data-bs-toggle="tab" href="#{{$Tab}}" role="tab" aria-controls="{{$Tab}}" aria-selected="true">{{$Tab}}</a>
					</li>
					@endforeach
				</ul>
				<div class="tab-content" id="myTabContent">
					@foreach($Data->Images->Images as $key => $Images)
						<div class="tab-pane fade @if($key < 'Default ') show active @endif" id="{{$key}}" role="tabpanel" aria-labelledby="{{$key}}-tab">
							@foreach($Images as $Ikey => $Image)
								<img src="{{$Image}}" class="img-fluid" alt="{{$key}}-{{$Ikey}}">
							@endforeach
						</div>
					@endforeach
				</div>
			</div>

		</div>
		<div class="card-body p-0 border-{{ $Data->Color }}">
			@foreach($Data->Attributes as $key => $Attribute)
				<table class="table table-bordered">
					<thead>
						<tr>
							<th scope="col" colspan="2" class="text-center">{{$key}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($Attribute as $Akey => $Att)
							@if($Att->Display == 'Inline')
								<tr class="d-{{$Att->Display}}">
									<th scope="col">{{$Akey}}</th>
									<td>
										@if($Att->Bool && $Att->Legend == 1)
											Yes
										@elseif($Att->Bool && $Att->Legend == 0)
											No
										@elseif($Att->HTML)
											{!!$Att->Value!!}
										@else
											{{$Att->Value}} 
										@endif

										@if($Att->Legend != '') <span>{{$Att->Legend}}</span> @endif</td>
								</tr>
							@else
								<tr class="d-{{$Att->Display}}">
									<th scope="col" colspan="2">{{$Akey}}</th>
								</tr>
								<tr class="d-{{$Att->Display}}">
									<td colspan="2">
										@if($Att->HTML)
											{!!$Att->Value!!}
										@else
											{{$Att->Value}} 
										@endif

										@if($Att->Legend != '')<span>({{$Att->Legend}})</span> @endif
									</td>
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>
			@endforeach
		</div>
		@if(isset($Data->Sets->Headers) && count((array)$Data->Sets) > 0)
		<div class="card-footer border-{{ $Data->Color }} bg-transparent table-responsive">
			<table class="table table-bordered" id="Sets">
			<thead>
				<tr>
					@foreach($Data->Sets->Headers as $Header)
						<th>{{ $Header }}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
			</tbody>
			</table>
		</div>
		@endif
	</div>
</div>
@endsection