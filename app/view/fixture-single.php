<?php require_once($this->pathView() . 'header.php'); ?>
<?php
/*
[player_left_full_name] => Matt Hirst
[player_right_full_name] => Les Phillipson
[player_left_id] => 52
[player_right_id] => 38
[left_rank_change] => -5
[right_rank_change] => 8
[left_score] => 2
[right_score] => 3
[team_left_id] => 11
[team_right_id] => 6
[team_left_name] => KSB A
[team_right_name] => Ramsbottom B
[team_left_score] => 17
[team_right_score] => 21
[status] => 
[date_fulfilled] => 1359280569
[player_left_guid] => http://localhost/git/mvc/player/52-matt-hirst/
[player_right_guid] => http://localhost/git/mvc/player/38-les-phillipson/
[team_left_guid] => http://localhost/git/mvc/team/11-ksb-a/
[team_right_guid] => http://localhost/git/mvc/team/6-ramsbottom-b/
 */


?>

<?php $fixture = $ttFixture->get(0); ?>

<div class="content fixture single">
	
	<h1><?php echo $fixture['team_left_name'] . ' vs ' . $fixture['team_right_name']; ?></h1>

	<span>Fulfilled on: <?php echo $fixture['date_fulfilled']; ?></span>

	<?php if ($ttFixture->getData()) : ?>

		<table width="100%" cellspacing="0" cellpadding="0">

		<?php while ($ttFixture->nextRow()) : ?>

			<tr<?php echo ($ttFixture->getRow('status') ? ' class="' . $ttFixture->getRow('status') . '"' : ''); ?>>
				<td>
					<?php if ($ttFixture->getRow('status') == 'doubles') : ?>
					Doubles
					<?php else : ?>
					<a href="<?php echo $ttFixture->getRow('player_left_guid'); ?>"><?php echo $ttFixture->getRow('player_left_full_name'); ?></a>
					<?php endif; ?>	
				</td>
				<td><?php echo $ttFixture->getRow('player_left_score'); ?></td>
				<td><?php echo $ttFixture->getRow('player_right_score'); ?></td>
				<td><a href="<?php echo $ttFixture->getRow('player_right_guid'); ?>"><?php echo $ttFixture->getRow('player_right_full_name'); ?></a></td>
			</tr>

		<?php endwhile; ?>

		</table>
	
	<?php endif; ?>	

</div> <!-- styling aid -->

<?php require_once($this->pathView() . 'footer.php'); ?>