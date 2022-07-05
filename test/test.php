<?php


public function generateFirstTurn( int $sleeves, array $plrs )
    {
        echo "Tableau plrs en argument";
        
        var_dump( $plrs[1] );
        var_dump($plrs[0]);
        $battle = [];
        $up;
        
        for( $i = 0; $i < $sleeves; $i++ )
        {
            $values = array_values( $battle );
            
            shuffle($plrs[1]);
            shuffle($plrs[0]);
            
            if( $plrs[0][$i]['team_id'] == $plrs[1][$i]['team_id'] )
            {
                foreach( $plrs[1] as $plr )
                {
                    var_dump("id plr : ".$plr["team_id"]);
                    var_dump("id plrs : ".$plrs[0][$i]['team_id']);
                    
                    if( $plrs[0][$i]['team_id'] != $plr['team_id'] && !in_array( $plr['user_id'], $values ) )
                    {
                        var_dump($plrs[0][$i]);
                        var_dump($plr);
                        $battle[$plrs[0][$i]['user_id']] = $plr['user_id'];
                    }
                    else
                    {
                        continue;
                    }
                }
                
                
                
            }
            else
            {
                echo "Else plrs 0 team id != plrs 1 team id";
                if( !array_key_exists($plrs[0][$i]['user_id'], $battle) && !in_array($plrs[1][$i]['user_id'], $values) )
                {
                    $battle[$plrs[0][$i]['user_id']] = $plrs[1][$i]['user_id'];
                }
                else
                {
                    continue;
                }
            }
        }
        
        var_dump( $battle );
        return $battle;
    }
    
    public function generateSecTurn( int $sleeves, array $plrs, array $first_turn )
    {
        
        $battle = [];
        shuffle($plrs[0]);
        shuffle($plrs[1]);
        
        for( $i = 0; $i < $sleeves; $i++ )
        {
            if( in_array( [ serialize($plrs[0][$i]) => $plrs[1][$i] ], $first_turn ) )
            {
                shuffle($plrs[0]);
                foreach( $plrs[0] as $plr )
                {

                    if( $plr['team_id'] == $plrs[1][$i]['team_id'] || in_array( [serialize($plr) => $plrs[1][$i] ], $first_turn ) || array_key_exists( serialize($plr), $battle ) )
                    {
                        continue;
                    }
                    else
                    {
                        $battle[$i] = [ serialize($plr) => $plrs[1][$i] ];    
                    }
                }    
            }
            else
            {
                if( $plrs[0][$i]['team_id'] == $plrs[1][$i]['team_id'] )
                {
                    shuffle($plrs[1]);
                    foreach( $plrs[1] as $plr )
                    {
                        if( $plrs[0][$i]['team_id'] == $plr['team_id'] || in_array( $plr, $battle ) || in_array( [serialize($plrs[0][$i]) => $plr ], $first_turn ) )
                        {
                            continue;
                        }
                        else
                        {
                            if( array_key_exists( serialize($plrs[0][$i]), $battle ) )
                            {
                                foreach( $plrs[0] as $plr_0 )
                                {
                                    if( array_key_exists( serialize($plr_0), $battle ) )
                                    {
                                        continue;
                                    }
                                    else
                                    {
                                        $battle[$i] = [ serialize($plr_0) => $plr];     
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    if( !array_key_exists(serialize($plrs[0][$i]), $battle) && !in_array($plrs[1][$i], $battle) )
                    {
                        $battle[$i] = [ serialize($plrs[0][$i]) => $plrs[1][$i] ];
                    }
                    else
                    {
                        echo "else";
                        $i--;
                        continue;
                    }
                }
            }
        }
        
        return $battle;
    }
    
    public function generateThirdTurn( int $sleeves, array $plrs, array $first_turn, array $sec_turn )
    {
        
        $battle = [];
        shuffle($plrs[0]);
        shuffle($plrs[1]);
        
        for( $i = 0; $i < $sleeves; $i++ )
        {
            if( in_array( [ serialize($plrs[0][$i]) => $plrs[1][$i] ], $first_turn ) || in_array( [ serialize($plrs[0][$i]) => $plrs[1][$i] ], $sec_turn ) )
            {
                foreach( $plrs[0] as $plr )
                {
                    if( $plr['team_id'] == $plrs[1][$i]['team_id'] || array_key_exists( serialize($plr), $battle ) || in_array( [serialize($plr) => $plrs[1][$i] ], $first_turn ) || in_array( [serialize($plr) => $plrs[1][$i] ], $sec_turn ) )
                    {
                        continue;
                    }
                    else
                    {
                        $battle[$i] = [ serialize($plr) => $plrs[1][$i] ];    
                    }
                    
                }    
            }
            else
            {
                if( $plrs[0][$i]['team_id'] == $plrs[1][$i]['team_id'] )
                {
                    foreach( $plrs[1] as $plr )
                    {
                        if( $plrs[0][$i]['team_id'] == $plr['team_id'] || in_array( $plr, $battle ) || in_array( [serialize($plrs[0][$i]) => $plr ], $first_turn ) || in_array( [serialize($plrs[0][$i]) => $plr ], $sec_turn ) )
                        {
                            continue;
                        }
                        else
                        {
                            $battle[$i] = [ serialize($plrs[0][$i]) => $plr];    
                        }
                    }
                }
                else
                {
                    if( !array_key_exists( serialize($plrs[0][$i]), $battle )  && !in_array($plrs[1][$i], $battle) )
                    {
                        $battle[$i] = [ serialize($plrs[0][$i]) => $plrs[1][$i] ];
                    }
                    else
                    {
                        $i--;
                        continue;
                    }
                }
            }
        }
        
        return $battle;
    }
    
    public function generateFourthTurn( int $sleeves, array $plrs, array $first_turn, array $sec_turn, array $third_turn )
    {
        
        $battle = [];
        shuffle($plrs[0]);
        shuffle($plrs[1]);
        
        for( $i = 0; $i < $sleeves; $i++ )
        {
            if( in_array( [ serialize($plrs[0][$i]) => $plrs[1][$i] ], $first_turn ) || in_array( [ serialize($plrs[0][$i]) => $plrs[1][$i] ], $sec_turn ) || in_array( [ serialize($plrs[0][$i]) => $plrs[1][$i] ], $third_turn ) )
            {
                foreach( $plrs[0] as $plr )
                {
                    if( $plr['team_id'] == $plrs[1][$i]['team_id'] || array_key_exists( serialize($plr), $battle ) || in_array( [serialize($plr) => $plrs[1][$i] ], $first_turn ) || in_array( [serialize($plr) => $plrs[1][$i] ], $sec_turn ) || in_array( [serialize($plr) => $plrs[1][$i] ], $third_turn ) )
                    {
                        continue;
                    }
                    else
                    {
                        $battle[$i] = [ serialize($plr) => $plrs[1][$i] ];    
                    }
                }    
            }
            else
            {
                if( $plrs[0][$i]['team_id'] == $plrs[1][$i]['team_id'] )
                {
                    foreach( $plrs[1] as $plr )
                    {
                        if( $plrs[0][$i]['team_id'] == $plr['team_id'] || in_array( $plr, $battle ) || in_array( [serialize($plrs[0][$i]) => $plr ], $first_turn ) || in_array( [serialize($plrs[0][$i]) => $plr ], $sec_turn ) || in_array( [serialize($plrs[0][$i]) => $plr ], $third_turn ) )
                        {
                            continue;
                        }
                        else
                        {
                            $battle[$i] = [ serialize($plrs[0][$i]) => $plr];    
                        }
                    }
                }
                else
                {
                    if( !array_key_exists( serialize($plrs[0][$i]), $battle)  && !in_array($plrs[1][$i], $battle) )
                    {
                        $battle[$i] = [ serialize($plrs[0][$i]) => $plrs[1][$i] ];
                    }
                    else
                    {
                        $i--;
                        continue;
                    }    
                }
            }
        }
        
        return $battle;
    }
    
    
    
    <?php if( isset($winners) && !empty($winners ) ) : ?>
        <?php switch( $turn_result ) : 
            case 1 : ?>
                <?php if( count($winners) % 2 == 0 ) : ?>
                    <p><a href="index.php?route=rank&eventID=<?= $_GET['eventID'] ?>">Accéder au classement</a></p>
                    <p><a href="index.php?route=nextIndividualTurn&eventID=<?= $_GET['eventID'] ?>&turn=2">Générer le second tour de sélection</a></p>
                <?php else : ?>
                    <p><a href="index.php?route=rank&eventID=<?= $_GET['eventID'] ?>">Accéder au classement</a></p>
                    <p><a href="index.php?route=nextIndividualTurn&eventID=<?= $_GET['eventID'] ?>&turn=2">Générer la ou les poule(s) de finale</a></p>
                <?php endif; ?>
            <?php break; ?>
            <?php case 2 : ?>
                <?php if( count($winners) % 2 == 0 ) : ?>
                    <p><a href="index.php?route=rank&eventID=<?= $_GET['eventID'] ?>">Accéder au classement</a></p>
                    <p><a href="index.php?route=nextIndividualTurn&eventID=<?= $_GET['eventID'] ?>&turn=3">Générer le troisème tour de sélection</a></p>
                <?php else : ?>
                    <p><a href="index.php?route=rank&eventID=<?= $_GET['eventID'] ?>">Accéder au classement</a></p>
                    <p><a href="index.php?route=nextIndividualTurn&eventID=<?= $_GET['eventID'] ?>&turn=3">Générer la ou les poule(s) de finale</a></p>
                <?php endif; ?>
            <?php case 3 : ?>
                <?php if( count($winners) % 2 == 0 ) : ?>
                    <p><a href="index.php?route=rank&eventID=<?= $_GET['eventID'] ?>">Accéder au classement</a></p>
                    <p><a href="index.php?route=nextIndividualTurn&eventID=<?= $_GET['eventID'] ?>&turn=4">Générer le quatrième tour de sélection</a></p>
                <?php else : ?>
                    <p><a href="index.php?route=rank&eventID=<?= $_GET['eventID'] ?>">Accéder au classement</a></p>
                    <p><a href="index.php?route=nextIndividualTurn&eventID=<?= $_GET['eventID'] ?>&turn=4">Générer la ou les poule(s) de finale</a></p>
                <?php endif; ?>
            <?php case 4 : ?>
                <?php if( count($winners) % 2 == 0 ) : ?>
                    <p><a href="index.php?route=rank&eventID=<?= $_GET['eventID'] ?>">Accéder au classement</a></p>
                    <p><a href="index.php?route=nextIndividualTurn&eventID=<?= $_GET['eventID'] ?>&turn=5">Générer le cinquième tour de sélection</a></p>
                <?php else : ?>
                    <p><a href="index.php?route=rank&eventID=<?= $_GET['eventID'] ?>">Accéder au classement</a></p>
                    <p><a href="index.php?route=nextIndividualTurn&eventID=<?= $_GET['eventID'] ?>&turn=5">Générer la ou les poule(s) de finale</a></p>
                <?php endif; ?>
            <?php case 5 : ?>
                <?php if( count($winners) % 2 == 0 ) : ?>
                    <p><a href="index.php?route=rank&eventID=<?= $_GET['eventID'] ?>">Accéder au classement</a></p>
                    <p><a href="index.php?route=nextIndividualTurn&eventID=<?= $_GET['eventID'] ?>&turn=6">Générer le sixième tour de sélection</a></p>
                <?php else : ?>
                    <p><a href="index.php?route=rank&eventID=<?= $_GET['eventID'] ?>">Accéder au classement</a></p>
                    <p><a href="index.php?route=nextIndividualTurn&eventID=<?= $_GET['eventID'] ?>&turn=6">Générer la ou les poule(s) de finale</a></p>
                <?php endif; ?>
            <?php case 6 : ?>
                    <p><a href="index.php?route=rank&eventID=<?= $_GET['eventID'] ?>">Accéder au classement</a></p>
                    <p><a href="index.php?route=nextIndividualTurn&eventID=<?= $_GET['eventID'] ?>&turn=6">Générer la ou les poule(s) de finale</a></p>
        <?php endswitch; ?>
    <?php endif; ?> 