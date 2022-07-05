import TournamentFunctions from './tournamentFunctions.js';

class TournamentOptions extends TournamentFunctions  

{
 
    generateOptions( totalPlayers, sleeveTime, previewTurn, turn, configuration, div1, div2, div3, matchs )
    {
        let functions = new TournamentFunctions;
        console.log("chargé");
        
        if( turn <= 13 )
        {
            matchs += functions.matchForLessThirteen( turn );
            let totalTime = matchs * (sleeveTime);
            let playTime = 10*Math.floor( ( totalTime / 60 ) / 10 );
            let maxTime = playTime + 5;
            
            div1.innerHTML = "";
            div2.innerHTML = `Le tournoi se déroulera en deux temps. La première étape est une phase de selection, chaque participant réalise un match, les vainqueurs sont qualifiés pour la selection suivante puis nous organisons une poule. Deuxième phase chaque joueur de la poule se rencontrera une fois et nous réaliserons un classement final. Il y aura un total de ${matchs} matchs pour une durée approximative de ${playTime}-${maxTime} minutes.`;
            
            configuration[0]["Total des matchs"] = matchs;
            configuration[0]["Poule"] = true;
            configuration[5]["Poule finale"] = true;
            configuration[5]["Matchs de poule final"] = functions.matchForLessThirteen( turn );
            configuration[5]["Joueurs par poule"] = turn;

        }
        else
        {
            
            let firstConfig = functions.createPool( turn );
            let count = 0;
            
            if( firstConfig["variante"] === "unique" )
            {
                let tabKeys = Object.keys(firstConfig);
                let tabValues = Object.values(firstConfig);
                let matchsGroup1 = functions.matchForLessThirteen( tabValues[0] );
                let totalMatchsGroup2 = functions.matchForLessThirteen( tabValues[1] )*parseInt(tabKeys[1], 10);
                let halfFinalMatch = parseInt(tabKeys[1], 10) + 1;
                let finalPool = functions.matchForLessThirteen( halfFinalMatch );
                let totalMatch = matchs + matchsGroup1 + totalMatchsGroup2 + halfFinalMatch + finalPool;
                let totalTime = 10*Math.floor( ( ( totalMatch * sleeveTime ) / 60 ) / 10 );
                
                div1.innerHTML = "";
                div2.innerHTML = `Le tournoi se déroulera en deux parties, la première phase 
                de séléction en ${matchs} matchs puis une phase de matchs en poules avec ${ tabKeys[0] } groupe de ${ tabValues[0] } joueurs et ${ tabKeys[1] } groupes de ${ tabValues[1] }. Il y aura un total de ${totalMatch} matchs pour une durée de tournoi d'environ ${ totalTime } minutes.`;
                
                configuration[0]["Total des matchs"] = totalMatch;
                configuration[0]["Poule"] = true;
                configuration[3]["Nombre de poules de selection"] = 1 + parseInt(tabKeys[1], 10);
                configuration[3]["Matchs de poule"] = matchsGroup1 + totalMatchsGroup2;
                configuration[3]["Joueurs par poule"] = tabValues[1];
                configuration[3]["Poule nombre premier"] = tabValues[0];
                configuration[4]["Tour de selection final"] = true;
                configuration[4]["Matchs de selection final"] = matchsGroup1 + totalMatchsGroup2 + halfFinalMatch;
                configuration[4]["Tour 1"] = matchsGroup1 + totalMatchsGroup2;
                configuration[4]["Tour 2"] = halfFinalMatch;
                configuration[5]["Poule finale"] = true;
                configuration[5]["Joueurs par poule"] = halfFinalMatch;
                configuration[5]["Matchs de poule final"] = finalPool;
            }
            else
            {
                configuration[0]["Poule"] = true;
                configuration[4]["Tours de selection final"] = true;
                
                div1.innerHTML = "";
                div2.innerHTML = `Le tournoi se déroulera en trois parties, la première phase de séléction en ${matchs} matchs puis une phase de matchs en poules qui sera défini selon vos choix :`;
                console.log("else1");
                
                for( const [key, value] of Object.entries( firstConfig ) ) 
                {
                    
                    let firstFinalTurn = key * functions.matchForLessThirteen( value );
                    let time = functions.matchForLessThirteen( value ) * sleeveTime;
                    let totalTime = time * parseInt( key, 10 );
                    let playTime = 10*Math.floor( ( totalTime / 60 ) /10 );
                            
                    count++;
                      
                    div3.innerHTML += `<section class="pool-block"><label for="pool-${ count }">${ key } Poules de ${ value }, temps de jeu de ${ playTime } minutes.</label>
                                <input type="radio" class="pool-radio" name="pool" id="pool-${ count }">
                                <div class="hidde-infos">
                                <input type="hidden" value="${ matchs }" class="select-matchs">
                                <input type="hidden" value="${ key }">
                                <input type="hidden" value="${ value }" class="players-for-pool">
                                <input type="hidden" value="${ firstFinalTurn }"></br>
                                <div class="final-div"></div></section>
                                </div>`;
                                
                }
                
                let radiosPool = document.querySelectorAll(".pool-radio");
        
                radiosPool.forEach( radio => {
                   
                  radio.addEventListener( "click", () => {
                      
                        let finalDivNode = document.querySelectorAll(".final-div");
                        let domRadioParent = radio.nextElementSibling;
                        let childDiv = domRadioParent.lastChild;
                        let powerTwoTab = [2, 4, 8, 16, 32, 64];
                        let selectMatchs = domRadioParent.childNodes[1].value;
                        let pools = domRadioParent.childNodes[3].value;
                        let finalPlayers = domRadioParent.childNodes[3].value * 2;
                        console.log(finalPlayers);
                        let plForPool = domRadioParent.childNodes[5].value;
                        let firstFinalTurn = domRadioParent.childNodes[7].value;
                        finalDivNode.forEach( el => {
                           el.innerHTML = ""; 
                        });
                        
                        if( powerTwoTab.indexOf( finalPlayers ) != -1 )
                        {
                            console.log("if");
                            let turn = finalPlayers;
                            let secTurn = functions.howManyMatch( finalPlayers );
                            let totalFinalMatch = parseInt(turn, 10) + parseInt(secTurn, 10);
                            let time = totalFinalMatch * sleeveTime;
                            let playTime = 10*Math.floor( ( time / 60 ) / 10 );
                            let totalMatch = parseInt(selectMatchs, 10) + parseInt( totalFinalMatch, 10);
                            
                            childDiv.innerHTML = `La partie finale du tournoi se déroulera en match simple par élimination directe, il n'en restera plus que deux pour la finale. Il y aura un total de ${ totalFinalMatch } matchs pour une durée d'environ ${ playTime } minutes`;
                            
                            configuration[0]["Total des matchs"] = totalMatch;
                            configuration[0]["Eliminatoire"] = true;
                            configuration[4]["Tour 2"] = secTurn;
                            configuration[5]["Poule finale"] = false;
                            configuration[5]["Joueurs par poule"] = null;
                            configuration[5]["Matchs de poules final"] = null; 
                            
                        }
                        else
                        {
                            console.log("else");
                            let turn = finalPlayers;
                            console.log(turn);
                            let secTurn = functions.matchForLessThirteen( finalPlayers );
                            let totalFinalMatch = parseInt(firstFinalTurn, 10) + parseInt(secTurn, 10);
                            let time = totalFinalMatch * sleeveTime;
                            let playTime = 10*Math.floor( ( time / 60 ) / 10 );
                            
                            childDiv.innerHTML = `La partie finale du tournoi se déroulera en deux phases, une phase de sélection pour accéder à la poule finale et la poule finale. Il y aura un total de ${ totalFinalMatch } matchs pour une durée d'environ ${ playTime } minutes`;
                            
                            
                            configuration[0]["Eliminatoire"] = false;
                            configuration[0]["Total des matchs"] = parseInt(selectMatchs, 10) + parseInt(totalFinalMatch, 10);
                            configuration[3]["Nombre de poules de selection"] = parseInt(pools, 10);
                            configuration[3]["Joueurs par poule"] = parseInt(plForPool, 10);
                            configuration[3]["Matchs de poule"] = parseInt(firstFinalTurn, 10);
                            configuration[4]["Matchs de selection final"] = parseInt(firstFinalTurn, 10);
                            configuration[4]["Tour 1"] = parseInt(firstFinalTurn, 10);
                            configuration[5]["Poule finale"] = true;
                            configuration[5]["Joueurs par poule"] = parseInt(turn, 10);
                            configuration[5]["Matchs de poule final"] = parseInt(secTurn, 10);
                    
                        }
                    });
                });
            }
        }
        
        return configuration;
    }
    
    generatePoolForLessThirteen( players, sleeveTime, div1, div2, configuration )
    {
        let functions = new TournamentFunctions();
        let matchs = functions.matchForLessThirteen( players );
            let totalTime = matchs * (sleeveTime - 10);
            let playTime = 10*Math.floor( ( totalTime / 60 ) / 10 );
            let maxTime = playTime + 5;
            
            div1.innerHTML = "";
            div2.innerHTML = `Chaque joueurs se rencontrera une fois et nous réaliserons un classement final. Il y aura un total de ${matchs} matchs pour une durée approximative de ${playTime}-${maxTime} minutes.`;
        
            configuration = 
            [{ 
                    "Joueurs total" : players, 
                    "Equipe" : false, 
                    "Individuel" : true, 
                    "Poules" : true,
                    "Eliminatoire" : false,
                    "Total des matchs" : matchs
                },
                {
                    "Nombre d'équipes" : null,
                    "Joueurs par équipes" : null,
                    "Total Matchs" : null,
                    "Tour 1" : null,
                    "Tour 2" : null,
                    "Tour 3" : null,
                    "Tour 4" : null
                },
                
                {
                    "Tours de selection" : false,
                    "Matchs de selection" : null,
                    "Tour 1" : null,
                    "Tour 2" : null,
                    "Tour 3" : null,
                    "Tour 4" : null,
                    "Tour 5" : null,
                    "Tour 6" : null
                },
                {
                    "Nombre de poules de selection" : null,
                    "Joueurs par poules" : null,
                    "Matchs de poule" : null
                },
                {
                    "Tour de selection final" : false,
                    "Matchs de selection final" : null,
                    "Tour 1" : null,
                    "Tour 2" : null,
                    "Tour 3" : null,
                    "Tour 4" : null,
                    "Tour 5" : null,
                    "Tour 6" : null
                },
                {
                    "Poule finale" : true,
                    "Joueurs par poules" : players,
                    "Matchs de poule finale" : matchs
            }];           
    }
}

export default TournamentOptions;