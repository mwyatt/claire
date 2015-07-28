<?php if ($encounters) : ?>
	<?php foreach ($encounters as $encounter) : ?>
		<?php $playerLeft = new \OriginalAppName\Site\Elttl\Entity\Tennis\Player ?>
		<?php $playerRight = new \OriginalAppName\Site\Elttl\Entity\Tennis\Player ?>
		<?php if (array_key_exists($encounter->playerIdLeft, $players)) : ?>
			<?php $playerLeft = $players[$encounter->playerIdLeft] ?>
		<?php
endif ?>
		<?php if (array_key_exists($encounter->playerIdRight, $players)) : ?>
			<?php $playerRight = $players[$encounter->playerIdRight] ?>
		<?php
endif ?>

<tr class="elttl-table-row <?php echo $encounter->status ? 'is-' . $encounter->status : '' ?>">
	<td class="elttl-table-cell">

		<?php if ($encounter->status == 'doubles') : ?>
		
			Doubles
			
		<?php
else : ?>
			<?php if ($encounter->playerRankChangeLeft != 0) : ?>
			
		<span class="encounter-rank-change" title="Rank change"><?php echo $encounter->playerRankChangeLeft ?></span>

			<?php
endif ?>
	
		<a href="<?php echo $this->url->generate('player/single', ['yearName' => $year->name, 'playerSlug' => $playerLeft->slug]) ?>"><?php echo $playerLeft->getNameFull() ?></a>
		<?php
endif ?>

	</td>
	<td class="elttl-table-cell is-score"><?php echo $encounter->scoreLeft ?></td>
	<td class="elttl-table-cell is-score"><?php echo $encounter->scoreRight ?></td>
	<td class="elttl-table-cell">

		<?php if ($encounter->playerRankChangeRight != 0) : ?>
		
		<span class="encounter-rank-change" title="Rank change"><?php echo $encounter->playerRankChangeRight ?></span>

		<?php
endif ?>
		
		<a href="<?php echo $this->url->generate('player/single', ['yearName' => $year->name, 'playerSlug' => $playerRight->slug]) ?>"><?php echo $playerRight->getNameFull() ?></a>
	</td>
</tr>

	<?php
endforeach ?>
<?php endif ?>
