<div class="row">
	<div class="col-lg-12">
		<!--<div class="corporateClients index large-9 medium-8 columns content">-->

		<div class="ibox float-e-margins">
			<div class = 'ibox-title'>
				<div class="text-right">
				<?=$this->Html->link('Add Corporate Client Notes', ['controller' => 'CorporateClientNotes', 'action' => 'add'],['class' => ['btn', 'btn-success']], ['data-toggle' => 'modal', 'data-target' => '#addNotes'])?>
				</div>
				<div class="text-right">
					<?=$this->Html->link('Add Corporate Client Document', ['controller' => 'CorporateClientDocuments', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
				</div>
				<div class="text-right">
					<?=$this->Html->link('View Attachments', ['controller' => 'CorporateClients', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
				</div>
			</div>
		</div>
	</div>
</div>