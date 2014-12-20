<?php if ($encounters): ?>
	<?php foreach ($encounters as $encounter): ?>
		<?php $playerLeft = new mold_tennis_player() ?>
		<?php $playerRight = new mold_tennis_player() ?>
		<?php if (array_key_exists($encounter->getPlayerIdLeft(), $players)): ?>
			<?php $playerLeft = $players[$encounter->getPlayerIdLeft()] ?>
		<?php endif ?>
		<?php if (array_key_exists($encounter->getPlayerIdRight(), $players)): ?>
			<?php $playerRight = $players[$encounter->getPlayerIdRight()] ?>
		<?php endif ?>

<tr class="elttl-table-row <?php echo $encounter->getStatus() ? 'is-' . $encounter->getStatus() : '' ?>">
	<td class="elttl-table-cell">

		<?php if ($encounter->getStatus() == 'doubles'): ?>
		
			Doubles
			
		<?php else: ?>
			<?php if ($encounter->getPlayerRankChangeLeft() != 0): ?>
			
		<span class="encounter-rank-change" title="Rank change"><?php echo $encounter->getPlayerRankChangeLeft() ?></span>

			<?php endif ?>
	
		<a href="<?php echo $this->buildArchiveUrl(array('player', $playerLeft->getNameFull())) ?>"><?php echo $playerLeft->getNameFull() ?></a>
		<?php endif ?>

	</td>
	<td class="elttl-table-cell is-score"><?php echo $encounter->getScoreLeft() ?></td>
	<td class="elttl-table-cell is-score"><?php echo $encounter->getScoreRight() ?></td>
	<td class="elttl-table-cell">

		<?php if ($encounter->getPlayerRankChangeRight() != 0): ?>
		
		<span class="encounter-rank-change" title="Rank change"><?php echo $encounter->getPlayerRankChangeRight() ?></span>

		<?php endif ?>
		
		<a href="<?php echo $this->buildArchiveUrl(array('player', $playerRight->getNameFull())) ?>"><?php echo $playerRight->getNameFull() ?></a>
	</td>
</tr>

	<?php endforeach ?>
<?php endif ?>
