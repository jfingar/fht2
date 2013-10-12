Course Name,Date Played,Score,Rating,Slope,Differential,Holes Played,Tees
<? foreach($this->scores as $score) : ?>
    <?= $score->getCourseName(); ?>,<?= date("m/d/Y",strtotime($score->getDate())); ?>,<?= $score->getScore(); ?>,<?= $score->getRating(); ?>,<?= $score->getSlope(); ?>,<?= $score->getDifferential(); ?>,<?= $score->getHolesPlayed(); ?>,<?= $score->getTees(); ?><?= PHP_EOL; ?>
<? endforeach; ?>
