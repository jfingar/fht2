Course Name,Date Played,Score,Rating,Slope,Differential,Holes Played,Tees
<? foreach($this->scores as $score) : ?>
    <?= $score->getCourseName(); ?>,<?= $score->getDate()->format("m/d/Y"); ?>,<?= $score->getScore(); ?>,<?= $score->getRating(); ?>,<?= $score->getSlope(); ?>,<?= $score->getDifferential(); ?>,<?= $score->getHolesPlayed(); ?>,<?= $score->getTees(); ?><?= PHP_EOL; ?>
<? endforeach; ?>
