////////////////////BOUTON EQUIPE CHECKED//////////////////////////////


    function recupUsers( target, int, select )
    {
        
        fetch("fetch/optionTeam.php?eventID="+eventId.value)
            .then(response => response.text())
            .then(resultat => {
                target.innerHTML += resultat;
            })
            .then( innerHtml => {
                let $chosen = $(`#chose-${select}`).chosen({
                  max_selected_options: int
                });
                
                $chosen.change(function () {
                  let $this = $(this);
                  let chosen = $this.data('chosen');
                  let search = chosen.search_container.find('input[type="text"]');
                  
                  search.prop('disabled', $this.val() !== null);
                  
                  if (chosen.active_field) 
                  {
                    search.focus();
                  }
                  
                }); 
            });
    }
    
    
    checkTeam.addEventListener( "click", () => {
        
        
        if( Object.keys(tabTeam).length === 0 )
        {
            divChoice.classList.remove("inActive");
            divChoice.innerHTML = `<p>Il y a actuellement ${ players.value } participants pour ce tournoi.</p>
                                    <p>Désolé, vous ne pouvez pas réaliser d'équipes équitables avec ce nombre de participants.</br>Nous vous proposons de réaliser un tournoi en individuel.</p>
                                    `;
        }
        else
        {
            let count = 0;
            
            for( let k in tabTeam )
            {
                count++;
                let value = tabTeam[k];

                divChoice.innerHTML += `<label for="team-${ count }">${ k } equipes de ${ value }</label>
                                        <input type="radio" class="team-radio" name="team" id="team-${ count }">
                                        <input type="hidden" value="${ k }">
                                        <input type="hidden" value="${ value }" class="players-for-team"></br>
                                        `;
            }
            
            let radios = document.querySelectorAll(".team-radio");
            
            radios.forEach( radio => {
                
                radio.addEventListener( "click", () => {
                    
                    divEdition.innerHTML = "";
                    
                
                    let count = radio.nextElementSibling.value;
                    let playersNbr = radio.nextElementSibling.nextElementSibling.value;
                    
                    
                    
                    for( let i = 0; i < count; i++)
                    {
                        divEdition.innerHTML +=`<label for="name-team-${ i + 1 }">Nom de l'équipe</label>
                                                <input type="text" name="name-team-${ i + 1 }">
                                                <select data-placeholder="Choissisez vos joueurs..." name="team-${ i + 1 }" multiple class="chosen-select" id="chose-${ i + 1 }">
                                                <option value></option>
                                                </select></br>
                                               `;
                    }
                    
                    let playersChoice = document.querySelectorAll(".chosen-select");
                    let start = 0;
                    
                    playersChoice.forEach( el => {
                        
                      start++; 
                      recupUsers( el, playersNbr, start );
                      
                    });
                });
            });
        }
        
       
        divChoice.classList.remove("inActive");
        divTeam.classList.remove("inActive");
        divIndiv.classList.add("inActive");
        divIndiv.classList.add("inActive");
        divPool.classList.add("inActive");
        
    });
    