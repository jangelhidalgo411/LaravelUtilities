@extends('Layouts.MainLayout')

@section('CustomStyles')
<link href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css" rel="stylesheet" />
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

.PokemonSpan {
	margin-right: 5px;
	padding: .25rem .75rem;
	border-radius: 25px;
	border: 1px solid black;
	text-transform: capitalize;
	display: inline-block;
	font-weight: bold;
}

input.form-control[type="range"],
input.form-control[type="range"]:disabled {
	-webkit-appearance: none !important;
	-moz-appearance: none !important;
	appearance: none !important;
	overflow:hidden;
	padding: 0;
	outline:none;
	background-color: transparent;
	accent-color: #58faac;
	color: transparent;
}


input.form-control[type="range"].stat-1, input.form-control[type="range"].stat-1:disabled,
input.form-control[type="range"].stat-2, input.form-control[type="range"].stat-2:disabled,
input.form-control[type="range"].stat-3, input.form-control[type="range"].stat-3:disabled,
input.form-control[type="range"].stat-4, input.form-control[type="range"].stat-4:disabled,
input.form-control[type="range"].stat-5, input.form-control[type="range"].stat-5:disabled,
input.form-control[type="range"].stat-6, input.form-control[type="range"].stat-6:disabled,
input.form-control[type="range"].stat-7, input.form-control[type="range"].stat-7:disabled,
input.form-control[type="range"].stat-8, input.form-control[type="range"].stat-8:disabled,
input.form-control[type="range"].stat-9, input.form-control[type="range"].stat-9:disabled,
input.form-control[type="range"].stat-10, input.form-control[type="range"].stat-10:disabled,
input.form-control[type="range"].stat-11, input.form-control[type="range"].stat-11:disabled,
input.form-control[type="range"].stat-12, input.form-control[type="range"].stat-12:disabled,
input.form-control[type="range"].stat-13, input.form-control[type="range"].stat-13:disabled,
input.form-control[type="range"].stat-14, input.form-control[type="range"].stat-14:disabled,
input.form-control[type="range"].stat-15, input.form-control[type="range"].stat-15:disabled,
input.form-control[type="range"].stat-16, input.form-control[type="range"].stat-16:disabled,
input.form-control[type="range"].stat-17, input.form-control[type="range"].stat-17:disabled,
input.form-control[type="range"].stat-18, input.form-control[type="range"].stat-18:disabled,
input.form-control[type="range"].stat-19, input.form-control[type="range"].stat-19:disabled,
input.form-control[type="range"].stat-20, input.form-control[type="range"].stat-20:disabled,
input.form-control[type="range"].stat-21, input.form-control[type="range"].stat-21:disabled,
input.form-control[type="range"].stat-22, input.form-control[type="range"].stat-22:disabled,
input.form-control[type="range"].stat-23, input.form-control[type="range"].stat-23:disabled,
input.form-control[type="range"].stat-24, input.form-control[type="range"].stat-24:disabled,
input.form-control[type="range"].stat-25, input.form-control[type="range"].stat-25:disabled,
input.form-control[type="range"].stat-26, input.form-control[type="range"].stat-26:disabled,
input.form-control[type="range"].stat-27, input.form-control[type="range"].stat-27:disabled,
input.form-control[type="range"].stat-28, input.form-control[type="range"].stat-28:disabled,
input.form-control[type="range"].stat-29, input.form-control[type="range"].stat-29:disabled,
input.form-control[type="range"].stat-30, input.form-control[type="range"].stat-30:disabled,
input.form-control[type="range"].stat-31, input.form-control[type="range"].stat-31:disabled,
input.form-control[type="range"].stat-32, input.form-control[type="range"].stat-32:disabled,
input.form-control[type="range"].stat-33, input.form-control[type="range"].stat-33:disabled,
input.form-control[type="range"].stat-34, input.form-control[type="range"].stat-34:disabled,
input.form-control[type="range"].stat-35, input.form-control[type="range"].stat-35:disabled,
input.form-control[type="range"].stat-36, input.form-control[type="range"].stat-36:disabled,
input.form-control[type="range"].stat-37, input.form-control[type="range"].stat-37:disabled,
input.form-control[type="range"].stat-38, input.form-control[type="range"].stat-38:disabled,
input.form-control[type="range"].stat-39, input.form-control[type="range"].stat-39:disabled,
input.form-control[type="range"].stat-40, input.form-control[type="range"].stat-40:disabled {
	accent-color: #fa5858;
}

input.form-control[type="range"].stat-41, input.form-control[type="range"].stat-41:disabled,
input.form-control[type="range"].stat-42, input.form-control[type="range"].stat-42:disabled,
input.form-control[type="range"].stat-43, input.form-control[type="range"].stat-43:disabled,
input.form-control[type="range"].stat-44, input.form-control[type="range"].stat-44:disabled,
input.form-control[type="range"].stat-45, input.form-control[type="range"].stat-45:disabled,
input.form-control[type="range"].stat-46, input.form-control[type="range"].stat-46:disabled,
input.form-control[type="range"].stat-47, input.form-control[type="range"].stat-47:disabled,
input.form-control[type="range"].stat-48, input.form-control[type="range"].stat-48:disabled,
input.form-control[type="range"].stat-49, input.form-control[type="range"].stat-49:disabled,
input.form-control[type="range"].stat-50, input.form-control[type="range"].stat-50:disabled,
input.form-control[type="range"].stat-51, input.form-control[type="range"].stat-51:disabled,
input.form-control[type="range"].stat-52, input.form-control[type="range"].stat-52:disabled,
input.form-control[type="range"].stat-53, input.form-control[type="range"].stat-53:disabled,
input.form-control[type="range"].stat-54, input.form-control[type="range"].stat-54:disabled,
input.form-control[type="range"].stat-55, input.form-control[type="range"].stat-55:disabled,
input.form-control[type="range"].stat-56, input.form-control[type="range"].stat-56:disabled,
input.form-control[type="range"].stat-57, input.form-control[type="range"].stat-57:disabled,
input.form-control[type="range"].stat-58, input.form-control[type="range"].stat-58:disabled,
input.form-control[type="range"].stat-59, input.form-control[type="range"].stat-59:disabled,
input.form-control[type="range"].stat-60, input.form-control[type="range"].stat-60:disabled,
input.form-control[type="range"].stat-61, input.form-control[type="range"].stat-61:disabled,
input.form-control[type="range"].stat-62, input.form-control[type="range"].stat-62:disabled,
input.form-control[type="range"].stat-63, input.form-control[type="range"].stat-63:disabled,
input.form-control[type="range"].stat-64, input.form-control[type="range"].stat-64:disabled,
input.form-control[type="range"].stat-65, input.form-control[type="range"].stat-65:disabled,
input.form-control[type="range"].stat-66, input.form-control[type="range"].stat-66:disabled,
input.form-control[type="range"].stat-67, input.form-control[type="range"].stat-67:disabled,
input.form-control[type="range"].stat-68, input.form-control[type="range"].stat-68:disabled,
input.form-control[type="range"].stat-69, input.form-control[type="range"].stat-69:disabled,
input.form-control[type="range"].stat-70, input.form-control[type="range"].stat-70:disabled,
input.form-control[type="range"].stat-71, input.form-control[type="range"].stat-71:disabled,
input.form-control[type="range"].stat-72, input.form-control[type="range"].stat-72:disabled,
input.form-control[type="range"].stat-73, input.form-control[type="range"].stat-73:disabled,
input.form-control[type="range"].stat-74, input.form-control[type="range"].stat-74:disabled,
input.form-control[type="range"].stat-75, input.form-control[type="range"].stat-75:disabled,
input.form-control[type="range"].stat-76, input.form-control[type="range"].stat-76:disabled,
input.form-control[type="range"].stat-77, input.form-control[type="range"].stat-77:disabled,
input.form-control[type="range"].stat-78, input.form-control[type="range"].stat-78:disabled,
input.form-control[type="range"].stat-79, input.form-control[type="range"].stat-79:disabled,
input.form-control[type="range"].stat-80, input.form-control[type="range"].stat-80:disabled {
	accent-color: #f7d358;
}

input.form-control[type="range"].stat-81, input.form-control[type="range"].stat-81:disabled,
input.form-control[type="range"].stat-82, input.form-control[type="range"].stat-82:disabled,
input.form-control[type="range"].stat-83, input.form-control[type="range"].stat-83:disabled,
input.form-control[type="range"].stat-84, input.form-control[type="range"].stat-84:disabled,
input.form-control[type="range"].stat-85, input.form-control[type="range"].stat-85:disabled,
input.form-control[type="range"].stat-86, input.form-control[type="range"].stat-86:disabled,
input.form-control[type="range"].stat-87, input.form-control[type="range"].stat-87:disabled,
input.form-control[type="range"].stat-88, input.form-control[type="range"].stat-88:disabled,
input.form-control[type="range"].stat-89, input.form-control[type="range"].stat-89:disabled,
input.form-control[type="range"].stat-90, input.form-control[type="range"].stat-90:disabled,
input.form-control[type="range"].stat-91, input.form-control[type="range"].stat-91:disabled,
input.form-control[type="range"].stat-92, input.form-control[type="range"].stat-92:disabled,
input.form-control[type="range"].stat-93, input.form-control[type="range"].stat-93:disabled,
input.form-control[type="range"].stat-94, input.form-control[type="range"].stat-94:disabled,
input.form-control[type="range"].stat-95, input.form-control[type="range"].stat-95:disabled,
input.form-control[type="range"].stat-96, input.form-control[type="range"].stat-96:disabled,
input.form-control[type="range"].stat-97, input.form-control[type="range"].stat-97:disabled,
input.form-control[type="range"].stat-98, input.form-control[type="range"].stat-98:disabled,
input.form-control[type="range"].stat-99, input.form-control[type="range"].stat-99:disabled,
input.form-control[type="range"].stat-100, input.form-control[type="range"].stat-100:disabled {
	accent-color: #f4fa58;
}

input.form-control[type="range"].stat-101, input.form-control[type="range"].stat-101:disabled,
input.form-control[type="range"].stat-102, input.form-control[type="range"].stat-102:disabled,
input.form-control[type="range"].stat-103, input.form-control[type="range"].stat-103:disabled,
input.form-control[type="range"].stat-104, input.form-control[type="range"].stat-104:disabled,
input.form-control[type="range"].stat-105, input.form-control[type="range"].stat-105:disabled,
input.form-control[type="range"].stat-106, input.form-control[type="range"].stat-106:disabled,
input.form-control[type="range"].stat-107, input.form-control[type="range"].stat-107:disabled,
input.form-control[type="range"].stat-108, input.form-control[type="range"].stat-108:disabled,
input.form-control[type="range"].stat-109, input.form-control[type="range"].stat-109:disabled,
input.form-control[type="range"].stat-110, input.form-control[type="range"].stat-110:disabled,
input.form-control[type="range"].stat-111, input.form-control[type="range"].stat-111:disabled,
input.form-control[type="range"].stat-112, input.form-control[type="range"].stat-112:disabled,
input.form-control[type="range"].stat-113, input.form-control[type="range"].stat-113:disabled,
input.form-control[type="range"].stat-114, input.form-control[type="range"].stat-114:disabled,
input.form-control[type="range"].stat-115, input.form-control[type="range"].stat-115:disabled,
input.form-control[type="range"].stat-116, input.form-control[type="range"].stat-116:disabled,
input.form-control[type="range"].stat-117, input.form-control[type="range"].stat-117:disabled,
input.form-control[type="range"].stat-118, input.form-control[type="range"].stat-118:disabled,
input.form-control[type="range"].stat-119, input.form-control[type="range"].stat-119:disabled,
input.form-control[type="range"].stat-120, input.form-control[type="range"].stat-120:disabled {
	accent-color: #82fa58;
}

/*input.form-control[type="range"]:disabled::-webkit-slider-runnable-track,
input.form-control[type="range"]::-webkit-slider-runnable-track,
input.form-control[type="range"]:disabled::-moz-range-track,
input.form-control[type="range"]::-moz-range-track,
input.form-control[type="range"]:disabled::-ms-fill-upper,
input.form-control[type="range"]::-ms-fill-upper {
	-webkit-appearance: auto !important;
	-moz-appearance: auto !important;
	appearance: auto !important;
	background-color: #00ff00 !important;
}

input.form-control[type="range"]:disabled::-webkit-slider-thumb,
input.form-control[type="range"]::-webkit-slider-thumb,
input.form-control[type="range"]:disabled::-moz-range-thumb,
input.form-control[type="range"]::-moz-range-thumb,
input.form-control[type="range"]::-ms-thumb,
input.form-control[type="range"]:disabled::-ms-thumb {
	-webkit-appearance: auto !important;
	-moz-appearance: auto !important;
	appearance: auto !important;
	height: 15px;
	width: 15px;
	border-radius:50%; 
	cursor: ew-resize;
	background: #ff0000 !important;
	box-shadow: -80px 0 0 80px #ff0000 !important;
}*/

.steel {
	background-color: #60a1b8;
}

.water {
	background-color: #2980ef;
}

.bug {
	background-color: #91a119;
}

.dragon {
	background-color: #5061e1;
}

.electric {
	background-color: #fac000;
}

.ghost {
	background-color: #704170;
}

.fire {
	background-color: #e62829;
}

.fairy {
	background-color: #ef71ef;
}

.ice {
	background-color: #3fd8ff;
}

.fighting {
	background-color: #ff8000;
}

.normal {
	background-color: #9fa19f;
}

.grass {
	background-color: #3fa129;
}

.psychic {
	background-color: #ef4179;
}

.rock {
	background-color: #afa981;
}

.dark {
	background-color: #50413f;
}

.ground {
	background-color: #915121;
}

.poison {
	background-color: #8f41cb;
}

.flying {
	background-color: #81b9ef;
}
</style>
@endsection

@section('CustomScripts')
<script type="text/javascript" src="//cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		new DataTable('#PokemonTable', {
			ajax: {
				url: '/Getpokemons?ExcludeFirst=0&AmountPerPage=100',
				type: 'POST'
			},
			order: [[0, 'asc']],
			columns: [
				{
					data: 'number',
					width: '5%'
				},
				{
					data: 'name',
				},
				{
					data: null,
					orderable: false,
					width: '15%',
					render: function (data, type) {
						return '<img src="'+data.normal+'" alt="'+data.name+' sprite">';
					}
				},
				{
					data: null,
					orderable: false,
					width: '15%',
					render: function (data, type) {
						return '<img src="'+data.shiny+'" alt="'+data.name+' sprite">';
					}
				},
				{
					data: null,
					orderable: false,
					width: '10%',
					render: function (data, type) {
						return '<button type="button" class="btn btn-light" onclick="ShowInfo(\''+data.name+'\')">ver</button>';
					}
				}
			]
		});
	});

	function ShowInfo(PokemonName) {
		$.get("/GetPokemonInfo/"+PokemonName, function(data, status){
			Swal.fire({
				title: PokemonName,
				html: data,
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
	<table id="PokemonTable" class="display compact" style="width:100%">
		<thead>
			<tr>
				<th>Number</th>
				<th>Name</th>
				<th>Normal Sprite</th>
				<th>Shiny Sprite</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

		</tbody>
		<tfoot>
			<tr>
				<th>Number</th>
				<th>Name</th>
				<th>Normal Sprite</th>
				<th>Shiny Sprite</th>
				<th></th>
			</tr>
		</tfoot>
	</table>
</div>
@endsection