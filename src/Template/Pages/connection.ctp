<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;
$tablaTurbinas = TableRegistry::get('Turbinas');
if(isset($_POST['_method'])){
	$consulta = $tablaTurbinas->query();
	if(isset($_POST['Accion'])){
		switch($_POST['Accion']){
			case "editar":
				$consulta->update()
					->set([
						'posicion'=>$_POST['Posicion'],
						'capacidad' => $_POST['Capacidad'],
						'temperatura' => $_POST['Temperatura'],
						'mantenimiento' =>	$_POST['Mantenimiento']['year'].
										"-".$_POST['Mantenimiento']['month'].
										"-".$_POST['Mantenimiento']['day'].
										" ".$_POST['Mantenimiento']['hour'].
										":".$_POST['Mantenimiento']['minute'],
						'instalacion' => $_POST['Instalacion']['year'].
										"-".$_POST['Instalacion']['month'].
										"-".$_POST['Instalacion']['day'].
										" ".$_POST['Instalacion']['hour'].
										":".$_POST['Instalacion']['minute']
					])
					->where(['id' => $_POST["ID"]])
					->execute();
			break;
			case "eliminar":
				$consulta->delete()
					->where(['id' => $_POST['ID']])
					->execute();
			break;
			case "duplicar":
				$consulta->insert(['posicion', 'capacidad', 'temperatura', 'mantenimiento'])
					->values([
						'posicion' => $_POST['Posicion'],
						'capacidad' => $_POST['Capacidad'],
						'temperatura' => $_POST['Temperatura'],
						'mantenimiento' => date("Y-m-d H:i:s")
					])
					->execute();
			break;
		}
	} else {
		$consulta->insert(['posicion', 'capacidad', 'temperatura', 'mantenimiento'])
			->values([
				'posicion' => $_POST['Posicion'],
				'capacidad' => $_POST['Capacidad'],
				'temperatura' => $_POST['Temperatura'],
				'mantenimiento' => date("Y-m-d H:i:s")
			])
			->execute();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio b Turbinas</title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('home.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
<body class="home">

<header class="row">
    <div class="header-title">
        <h1>Editar turbinas.</h1>
    </div>
</header>

<div class="row">
    <div class="columns large-12">
        <h4>Turbinas</h4>
	</div>
    <div class="columns large-12">
		<table class="table">
			<thead>
				<tr>
					<td class="large-1">ID</td>
					<td class="large-1">Posicion</td>
					<td class="large-1">Capacidad</td>
					<td class="large-1">Temperatura</td>
					<td class="large-3">Instalación</td>
					<td class="large-3">Mantenimiento</td>
					<td class="large-2">Acción</td>
				</tr>
			</thead>
			<tbody id="listaUsuarios">
				<?php
				$turbinas = $tablaTurbinas->find();
				foreach ($turbinas as $turbina) {
					echo $this->Form->create('Turbina'.$turbina['id'], array('id' => 'listaTurbina'.$turbina['id'], 'default' => false));
					echo '<tr>';
						echo '<td>'.$turbina['id'].$this->Form->input('ID', ['type' => 'hidden','value'=>$turbina['id']]).'</td>';
						echo '<td>'.$this->Form->input('Posicion', ['type' => 'number', 'label'=>'', 'placeholder'=>'Posición', 'value'=>$turbina['posicion']]).'</td>';
						echo '<td>'.$this->Form->input('Capacidad', ['type' => 'number', 'label'=>'', 'placeholder'=>'Capacidad', 'value'=>$turbina['capacidad']]).'</td>';
						echo '<td>'.$this->Form->input('Temperatura', ['type' => 'number', 'label'=>'', 'placeholder'=>'Temperatura', 'value'=>$turbina['temperatura']]).'</td>';
						echo '<td>'.$this->Form->input('Instalacion', ['type' => 'datetime', 'label'=>'', 'placeholder'=>'Instalación', 'value'=>$turbina['instalacion']]).'</td>';
						echo '<td>'.$this->Form->input('Mantenimiento', ['type' => 'datetime', 'label'=>'', 'placeholder'=>'Mantenimiento', 'value'=>$turbina['mantenimiento']]).'</td>';
						echo '<td>';
							echo $this->Form->select('Accion', ['editar' => 'Guardar', 'duplicar' => 'Duplicar', 'eliminar' => 'Eliminar'], ['default' => 'editar']);
							echo $this->Form->button('Ir', ['type' => 'submit']);
						echo '</td>';
					echo '</tr>';
					echo $this->Form->end();
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td class="large-1">ID</td>
					<td class="large-1">Posicion</td>
					<td class="large-1">Capacidad</td>
					<td class="large-1">Temperatura</td>
					<td class="large-3">Instalación</td>
					<td class="large-3">Mantenimiento</td>
					<td class="large-2">Acción</td>
				</tr>
			</tfoot>
		</table>
    </div>
</div>

<div class="row">
	<div class="columns large-12">
        <h4>Crear Turbina</h4>
		<?php
			echo $this->Form->create('Turbina', array('id' => 'crearTurbina', 'default' => false));
			echo $this->Form->input('Capacidad', ['type' => 'number', 'label'=>'', 'placeholder'=>'Capacidad']);
			echo $this->Form->input('Temperatura', ['type' => 'number', 'label'=>'', 'placeholder'=>'Temperatura']);
			echo $this->Form->input('Posicion', ['type' => 'number', 'label'=>'', 'placeholder'=>'Posicion']);
			echo $this->Form->button('Guardar', ['type' => 'submit']);
			echo $this->Form->end();
		?>
    </div>
    <hr />
</div>

</body>
</html>
