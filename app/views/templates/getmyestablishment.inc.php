<form method="post" action="index.php?action=searchResult" class="modal">
	<div class="modal-header">
		<h3 style="text-align:center">Vos établissements</h3>
	</div>
	<div class="form-horizontal modal-body">
		<table>
			<tr><td>Nom</td><td>Lieu</td></tr>
		<?php
				//if ($this->message!==""){
				//	echo '<div class="alert '.$this->style.'">'.$this->message.'</div>';
				//}
				//else{
					$uid = $_SESSION['login'];
						
					foreach($establishments as $establishment){
							
								echo("<tr><td>" . $establishment->name .  "</td><td>" . $establishment->city . "</td></tr><br>");
							
					}
				//}
		
		
		?>
		</table>
		</div> <!-- Fin du formulaire -->
</form>