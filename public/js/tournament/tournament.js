//Fichier contenant la classe qui genere les différents scenario de tournoi
import TournamentOptions from '../modules/optionsTournament.js'; 


document.addEventListener("DOMContentLoaded", () => {

    //mail responsable creation event bdd + formulaire
    //lien invitation
    //tri delete users rgpd newsletter
    
    
//Recuperation des éléments du dom nécessaire à la gestion des données
    const optionsTournament = new TournamentOptions();
    const form = document.getElementById("tournament-form");
    const eventId = document.getElementById("event-id").value;
    const users = document.getElementById("nbr-players");
    const checkTeam = document.getElementById("team");
    const checkSolo = document.getElementById("solo");
    const divTeam = document.getElementById("team-compositor");
    const paraIntro = document.getElementById("para-intro");
    const divChoice = document.getElementById("team-choice");
    const paraTime = document.getElementById("play-time");
    const indivInfo = document.getElementById("individual-info");
    const indivParaTime = document.getElementById("indiv-play-time");
    const poolChoice = document.getElementById("pool-choice");
    const tabTeam = optionsTournament.createTabTeam( users.value );
    const sleeveTime = 110;
    let config;
    
//Création de l'objet définissant la configuration du tournoi :

    let configuration = [
                            { 
                                "Joueurs total" : parseInt( users.value, 10 ), 
                                "Equipe" : false, 
                                "Individuel" : false, 
                                "Poule" : false,
                                "Eliminatoire" : false,
                                "Total des matchs" : null
                            },
                            {
                                "Nombre d'équipes" : null,
                                "Joueurs par équipe" : null,
                                "Total matchs" : null
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
                                "Joueurs par poule" : null,
                                "Poule nombre premier" : null,
                                "Matchs de poule" : null
                            },
                            {
                                "Tours de selection final" : false,
                                "Matchs de selection final" : null,
                                "Tour 1" : null,
                                "Tour 2" : null,
                                "Tour 3" : null,
                                "Tour 4" : null,
                                "Tour 5" : null,
                                "Tour 6" : null
                            },
                            {
                                "Poule finale" : false,
                                "Joueurs par poule" : null,
                                "Matchs de poule final" : null
                            }];
   
 
////////////////////BOUTON EQUIPE CHECKED//////////////////////////////
    checkTeam.addEventListener( "click", () => {

//On récupère les données joueurs pour vérifier les différentes possibilités de jeu en équipe puis on propose les choix au responsable
        
        if( Object.keys(tabTeam).length === 0 )
        {
            paraIntro.classList.add("inActive");
            divChoice.classList.remove("inActive");
            divChoice.innerHTML = `<p>Désolé, vous ne pouvez pas réaliser d'équipes équitables avec ce nombre de participants.</br>Nous vous proposons de réaliser un tournoi en individuel.</p>
                                    `;
        }
        else
        {
            let count = 0;
            
            if( divChoice.textContent === "" )
            {
                //Après avoir passé le nombre de joueurs dans la fonction createTabTeam() on va créer des checkbox pour chaque tableau contenu dans l'objet tabTeam
                for( let k in tabTeam )
                {
                    count++;
                    let value = tabTeam[k];
                    let sleeves = 2 * k * value;
                    let sleevesTime = sleeves * sleeveTime;
                    let playTime = 10*Math.floor((sleevesTime / 60)/10);
                    let maxTime = playTime + 5;
                    
                    
                    paraTime.innerHTML = `Le tournoi se déroulera en ${sleeves} matchs, et sera d'une durée approximative de ${playTime}-${maxTime} minutes.`;
                    
                    divChoice.innerHTML += `<label for="team-${ count }">${ k } equipes de ${ value }</label>
                                            <input type="radio" class="team-radio" name="team" id="team-${ count }">
                                            <div id="hidde-infos">
                                            <input type="hidden" value="${ k }" class="teams">
                                            <input type="hidden" value="${ sleeves }" class="sleeves">
                                            <input type="hidden" value="${ value }" class="players-for-team">
                                            </div>
                                            `;
                }
                
                let teamRadios = document.querySelectorAll(".team-radio");
                //Pour chaque box radio on met un ecouteur d'event qui permet de configurer notre variable de configuration de tournoi
                teamRadios.forEach( radio => {
                   
                    radio.addEventListener( "click", () => {
                        
                        let divInfos = radio.nextElementSibling;
                        let teams = divInfos.childNodes[1].value;
                        let matchs = divInfos.childNodes[3].value;
                        let players = divInfos.childNodes[5].value;
                        let sleeves = matchs / 4;
                      
                        configuration = 
                        [{ 
                                "Joueurs total" : parseInt(users.value, 10), 
                                "Equipe" : true, 
                                "Individuel" : false, 
                                "Poule" : false,
                                "Eliminatoire" : false,
                                "Total des matchs" : parseInt(matchs, 10)
                            },
                            {
                                "Nombre d'équipes" : parseInt(teams, 10),
                                "Joueurs par équipe" : parseInt(players, 10),
                                "Total matchs" : parseInt(matchs, 10),
                                "Tour 1" : sleeves,
                                "Tour 2" : sleeves,
                                "Tour 3" : sleeves,
                                "Tour 4" : sleeves
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
                                "Joueurs par poule" : null,
                                "Poule nombre premier" : null,
                                "Matchs de poule" : null
                            },
                            {
                                "Tours de selection final" : false,
                                "Matchs de selection final" : null,
                                "Tour 1" : null,
                                "Tour 2" : null,
                                "Tour 3" : null,
                                "Tour 4" : null,
                                "Tour 5" : null,
                                "Tour 6" : null
                            },
                            {
                                "Nombre de poules de final" : null,
                                "Joueurs par poule" : null,
                                "Matchs de poule final" : null
                        }];    
                       console.log(configuration);
                    });
                    
                });
            }
            
        }
        
        indivParaTime.innerHTML = "";
        poolChoice.innerHTML = "";
        indivInfo.classList.add("inActive");
        divChoice.classList.remove("inActive");
        divTeam.classList.remove("inActive");
        
    });
    
    
    

////////////////////BOUTON INDIVIDUEL CHECKED//////////////////////////////    
    
    checkSolo.addEventListener( "click", () => {
        
        configuration[0]["Equipe"] = false;
        configuration[0]["Individuel"] = true;
        

//On récupère les données joueurs pour vérifier les différentes possibilités de jeu en individuel puis on propose les choix au responsable
        
        
        //Si il y a 13 joueurs ou moins on passe la méthode suivante qui organise une poule où chacun se rencontre une fois; le resultat final est obtenu grace à un classement général
        if( parseInt(users.value, 10) <= 13 )
        {
            configuration[0]["Eliminatoire"] = false;
            configuration[0]["Poule"] = true;
            configuration[5]["Nombre de poules de final"] = 1;
            configuration[5]["Joueurs par poule"] = parseInt(users.value, 10);
            
            config = optionsTournament.generatePoolForLessThirteen( parseInt(users.value, 10), sleeveTime, divChoice, indivParaTime, configuration );  
        }
        //PREMIER TOUR DE SELECTION
        else if( parseInt(users.value, 10) % 2 == 0 && parseInt(users.value, 10) > 13 )
        {
            let firstTurn = parseInt(users.value, 10) / 2;
            // let firstTurn = 17;
            
            //DEUXIEME TOUR DE SELECTION
            if( firstTurn % 2 == 0 )
            {
                let secTurn = firstTurn / 2;
                
                //TROISIEME TOUR DE SELECTION
                if( secTurn % 2 == 0 )
                {
                    let thirdTurn = secTurn / 2;

                    //QUATRIEME TOUR DE SELECTION
                    if( thirdTurn % 2 == 0 )
                    {
                        let fourthTurn = thirdTurn / 2;
                        
                        //CINQUIEME TOUR DE SELECTION
                        if( fourthTurn % 2 == 0 )
                        {
                            let fifthTurn = fourthTurn / 2;
                            
                            if( fifthTurn % 2 == 0 )
                            {
                                let sixthTurn = fifthTurn / 2;
                                
                                let matchs = sixthTurn + fifthTurn + fourthTurn + thirdTurn + secTurn + firstTurn ;
                                
                                configuration[2]["Tours de selection"] = true;
                                configuration[2]["Matchs de selection"] = matchs;
                                configuration[2]["Tour 1"] = firstTurn;
                                configuration[2]["Tour 2"] = secTurn;
                                configuration[2]["Tour 3"] = thirdTurn;
                                configuration[2]["Tour 4"] = fourthTurn;
                                configuration[2]["Tour 5"] = fifthTurn;
                                configuration[2]["Tour 6"] = sixthTurn;
                                
                             
                                 let config = optionsTournament.generateOptions( parseInt( users.value, 10 ), 110, fourthTurn, fifthTurn, configuration, divChoice, indivParaTime, poolChoice, matchs );
                                 
                            }
                            else 
                            {
                                let matchs = fifthTurn + fourthTurn + thirdTurn + secTurn + firstTurn ;
                                
                                configuration[2]["Tours de selection"] = true;
                                configuration[2]["Matchs de selection"] = matchs;
                                configuration[2]["Tour 1"] = firstTurn;
                                configuration[2]["Tour 2"] = secTurn;
                                configuration[2]["Tour 3"] = thirdTurn;
                                configuration[2]["Tour 4"] = fourthTurn;
                                configuration[2]["Tour 5"] = fifthTurn;
                                
                        config = optionsTournament.generateOptions( parseInt( users.value, 10 ), 110, fourthTurn, fifthTurn, configuration, divChoice, indivParaTime, poolChoice, matchs );
                            }
                        }
                        //QUATRIEME TOUR DE SELECTION
                        else 
                        {
                           let matchs = fourthTurn + thirdTurn + secTurn + firstTurn ;
                           
                            configuration[2]["Tours de selection"] = true;
                            configuration[2]["Matchs de selection"] = matchs;
                            configuration[2]["Tour 1"] = firstTurn;
                            configuration[2]["Tour 2"] = secTurn;
                            configuration[2]["Tour 3"] = thirdTurn;
                            configuration[2]["Tour 4"] = fourthTurn;
                            
                        config = optionsTournament.generateOptions( parseInt( users.value, 10 ), 110, thirdTurn, fourthTurn, configuration, divChoice, indivParaTime, poolChoice, matchs );
                            
                        }
                    }
                    //TROISIEME TOUR DE SELECTION
                    else
                    {
                        console.log("3");
                        let matchs = thirdTurn + secTurn + firstTurn ;
                        
                        configuration[2]["Tours de selection"] = true;
                        configuration[2]["Matchs de selection"] = matchs;
                        configuration[2]["Tour 1"] = firstTurn;
                        configuration[2]["Tour 2"] = secTurn;
                        configuration[2]["Tour 3"] = thirdTurn;
                         
                        config = optionsTournament.generateOptions( parseInt(users.value, 10), 110, secTurn, thirdTurn, configuration, divChoice, indivParaTime, poolChoice, matchs );
                        
                    }  
                }
                //DEUXIEME TOUR DE SELECTION
                else
                {
                    console.log("2");
                    
                    let matchs = secTurn + firstTurn;
                    
                    configuration[2]["Tours de selection"] = true;
                    configuration[2]["Matchs de selection"] = matchs;
                    configuration[2]["Tour 1"] = firstTurn;
                    configuration[2]["Tour 2"] = secTurn;
                    
                    config = optionsTournament.generateOptions( parseInt( users.value, 10 ), 110, firstTurn, secTurn, configuration, divChoice, indivParaTime, poolChoice, matchs );
                    
                }
            }
            //PREMIER TOUR DE SELECTION
            else
            {
                let matchs = firstTurn;
                console.log(matchs);
                configuration[2]["Tours de selection"] = true;
                configuration[2]["Matchs de selection"] = matchs;
                configuration[2]["Tour 1"] = firstTurn;
                
                config = optionsTournament.generateOptions( parseInt(users.value, 10), 110, parseInt(users.value, 10), firstTurn, configuration, divChoice, indivParaTime, poolChoice, matchs);
            }
        }
        else
        {
            
            let tournamentConfig = optionsTournament.createPool( parseInt(users.value, 10) );
            let count = 0;
            
            if( tournamentConfig["variante"] === "unique" )
            {
                let tabKeys = Object.keys(tournamentConfig);
                let tabValues = Object.values(tournamentConfig);
                let matchsGroup1 = optionsTournament.matchForLessThirteen( tabValues[0] );
                let totalMatchsGroup2 = optionsTournament.matchForLessThirteen( tabValues[1] )*parseInt(tabKeys[1], 10);
                let halfFinalMatch = parseInt(tabKeys[1], 10) + 1;
                let finalPool = optionsTournament.matchForLessThirteen( halfFinalMatch );
                let totalMatch = matchsGroup1 + totalMatchsGroup2 + halfFinalMatch + finalPool;
                let totalTime = 10*Math.floor( ( ( totalMatch * sleeveTime ) / 60 ) / 10 );
                
                divChoice.innerHTML = "";
                indivParaTime.innerHTML = `Le tournoi sera organisé en poules avec ${ tabKeys[0] } groupe de ${ tabValues[0] } joueurs et ${ tabKeys[1] } groupes de ${ tabValues[1] }. Il y aura un total de ${totalMatch} matchs pour une durée de tournoi d'environ ${ totalTime } minutes.`;
                
            }
            else
            {
                divChoice.innerHTML = "";
                indivParaTime.innerHTML = `Le tournoi se déroulera en poules qui seront configurées selon vos choix :`;
                console.log("else1turn");
                
                for( const [key, value] of Object.entries( tournamentConfig ) ) 
                {
                    let time = optionsTournament.matchForLessThirteen( value ) * sleeveTime;
                    let totalTime = time * parseInt( key, 10 );
                    let playTime = 10*Math.floor( ( totalTime / 60 ) /10 );
                            
                    count++;
                      
                    poolChoice.innerHTML += `<section class="pool-block"><label for="pool-${ count }">${ key } Poule de ${ value }, temps de jeu de ${ playTime } minutes.</label>
                                        <input type="radio" class="pool-radio" name="pool" id="pool-${ count }">
                                        <input type="hidden" value="${ key }">
                                        <input type="hidden" value="${ value }" class="players-for-pool"></br>
                                        <div class="final-div"></div></section>`;
                }
                
                let radiosPool = document.querySelectorAll(".pool-radio");
                
                radiosPool.forEach( radio => {
                   
                  radio.addEventListener( "click", () => {
                      
                        let finalDivNode = document.querySelectorAll(".final-div");
                        let domRadioParent = radio.parentElement;
                        let childDiv = domRadioParent.lastChild;
                        let inputNbrPools = radio.nextElementSibling;
                        let inputNbrPlyrs = inputNbrPools.nextElementSibling; 
                        let powerTwoTab = [2, 4, 8, 16, 32, 64];
                        let players = inputNbrPlyrs.value;
                        let pools = inputNbrPools.value;
                        let radioId = radio.id;
                        
                        finalDivNode.forEach( el => {
                           el.innerHTML = ""; 
                        });
                        
                        if( powerTwoTab.indexOf( pools ) != -1 )
                        {
                            let firstTurn = pools;
                            let secTurn = optionsTournament.howManyMatch( pools );
                            let totalMatch = parseInt(firstTurn, 10) + parseInt(secTurn, 10);
                            let time = totalMatch * sleeveTime;
                            let playTime = 10*Math.floor( ( time / 60 ) / 10 );
                            
                            childDiv.innerHTML = `La partie finale du tournoi se déroulera en match simple par élimination directe, il n'en restera plus que deux pour la finale. Il y aura un total de ${ totalMatch } matchs pour une durée d'environ ${ playTime } minutes`;
                        }
                        else
                        {
                            let firstTurn = pools;
                            let secTurn = optionsTournament.matchForLessThirteen( pools );
                            let totalMatch = parseInt(firstTurn, 10) + parseInt(secTurn, 10);
                            let time = totalMatch * sleeveTime;
                            let playTime = 10*Math.floor( ( time / 60 ) / 10 );
                            
                            childDiv.innerHTML = `La partie finale du tournoi se déroulera en deux phases, une phase de sélection pour accéder à la poule finale et la poule finale. Il y aura un total de ${ totalMatch } matchs pour une durée d'environ ${ playTime } minutes`;
                        }
                    });
                });
            }
        }

        indivInfo.classList.remove("inActive");
        divTeam.classList.add("inActive");
    });
    
////////////////////VALIDATION FORMULAIRE//////////////////////////////    
    
    form.addEventListener( "submit", (e) =>{
       
        e.preventDefault();
        console.log(configuration);
                      
        let date = new Date(Date.now() + 86400000); //86400000ms = 1 jour
            
        document.cookie = `config=${JSON.stringify(configuration)}; path=/; expires=${date}`;
        document.cookie = `eventId=${eventId}; path=/; expires=${date}`;
        
        document.location.href = "index.php?route=newTournament";
                    
                    // let xhr = new XMLHttpRequest();
            
                    // let dataToSend = new FormData();
                    // dataToSend.set( 'matchs', matchs );
                    // dataToSend.set( 'playersForTeams', playersForTeams );
                    // dataToSend.set( 'teams', teams );
                    // dataToSend.set( 'firstTurn', firstTurn );
                    // dataToSend.set( 'secTurn', secTurn );
                    // dataToSend.set( 'thirdTurn', thirdTurn );
                    // dataToSend.set( 'fourthTurn', fourthTurn );
               
                    // xhr.open('POST', 'index.php?route=newTournament', true);
                    // xhr.send( dataToSend );
                    // document.location.href = "index.php?route=newTournament";
      
        
    });
    
});
