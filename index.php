<?php
  include 'FootballData.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            echo "Showcasing some library functions...<p>";
            
            // Create instance of API class
            $api = new FootballData();            
            // fetch and dump summary data for premier league' season 2015/16
            $soccerseason = $api->getSoccerseasonById(398);                        
            echo "<p><hr><p>";
            
            // show fixtures for the 1st matchday of that soccerseason. ?>            
            <table>
                <caption style="text-align:left">Fixtures for the 1st matchday of <? echo $soccerseason->payload->caption; ?></caption>
                <tr>
                <th>HomeTeam</th>
                <th></th>
                <th>AwayTeam</th>
                <th colspan="3">Result</th>
                </tr>
                <?php foreach ($soccerseason->getFixturesByMatchday(1) as $fixture) { ?>            
                <tr> <? //var_dump($fixture); ?>
                    <td><? echo $fixture->homeTeamName; ?></td>
                    <td>-</td>
                    <td><? echo $fixture->awayTeamName; ?></td>
                    <td><? echo $fixture->result->goalsHomeTeam; ?></td>
                    <td>:</td>
                    <td><? echo $fixture->result->goalsAwayTeam; ?></td>
                </tr>
                <? } ?>
            </table>            
        <?      
            echo "<p><hr><p>";            
            // fetch all available upcoming fixtures for the next week and display
            $now = new DateTime();            
            $end = $now->add(new DateInterval('P27D'));                        
            $response = $api->getFixturesForDateRange($now->format('Y-m-d'), $end->format('Y-m-d'));
        ?>
            <table>
                <caption style="text-align:left">Upcoming fixtures in the next week:</caption>
                <tr>
                    <th>HomeTeam</th>
                    <th></th>
                    <th>AwayTeam</th>
                    <th colspan="3">Result</th>
                </tr>
                <?php foreach ($response->fixtures as $fixture) { ?>            
                <tr>
                    <td><? echo $fixture->homeTeamName; ?></td>
                    <td>-</td>
                    <td><? echo $fixture->awayTeamName; ?></td>
                    <td><? echo $fixture->result->goalsHomeTeam; ?></td>
                    <td>:</td>
                    <td><? echo $fixture->result->goalsAwayTeam; ?></td>
                </tr>
                <? } ?>
            </table>
        
        <?      
            echo "<p><hr><p>";            
            // search for desired team
            $searchQuery = $api->searchTeam(urlencode("Real Madrid"));
            // var_dump searchQuery and inspect for results
            $response = $api->getTeamById($searchQuery->teams[0]->id);
            $fixtures = $response->getFixtures('home')->fixtures;
        ?>
            <table>
                <caption style="text-align:left">All home matches of Real Madrid:</caption>
                <tr>
                    <th>HomeTeam</th>
                    <th></th>
                    <th>AwayTeam</th>
                    <th colspan="3">Result</th>
                </tr>
                <?php foreach ($fixtures as $fixture) { ?>            
                <tr>
                    <td><? echo $fixture->homeTeamName; ?></td>
                    <td>-</td>
                    <td><? echo $fixture->awayTeamName; ?></td>
                    <td><? echo $fixture->result->goalsHomeTeam; ?></td>
                    <td>:</td>
                    <td><? echo $fixture->result->goalsAwayTeam; ?></td>
                </tr>
                <? } ?>
            </table>
        
        
        
        <?      
            echo "<p><hr><p>";            
            // fetch players for a specific team            
            $team = $api->getTeamById(17);
        ?>
        <table>
            <caption style="text-align:left">Players of <? echo $team->_payload->name; ?>:</caption>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Jersey Number</th>
                <th>Date of birth</th>    
            </tr>
            <? foreach ($team->getPlayers() as $player) { ?>
            <tr>
                <td><? echo $player->name; ?></td>
                <td><? echo $player->position; ?></td>
                <td><? echo $player->jerseyNumber; ?></td>
                <td><? echo $player->dateOfBirth; ?></td>
            </tr>            
            <? } ?>
        </table>
    </body>
</html>
