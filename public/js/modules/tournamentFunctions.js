class TournamentFunctions

{
//Fonction pour la création d'un objet definissant les différents types de configurations d'équipes selon le nombre de joueurs    
    createTabTeam( nbrPlayer )
    {
        let tabTeam = new Object();
        
        for( let i = 2; i < nbrPlayer; i++ )
        {
            let modulo = nbrPlayer % i;
            let diviseur = nbrPlayer / i;
            
            if( modulo == 0 )
            {
                tabTeam[ i ] = diviseur;
            }
        }
        
        return tabTeam;
    }
    
//Fonction pour la création d'un objet definissant les différents types de configurations de poules selon le nombre de joueurs    
    createPool( nbrPlayer )
    {
        let resultNbr = this.nbrPremier( nbrPlayer );
        let poolTab = new Object();
        
        if( resultNbr )
        {
            let restPool = nbrPlayer - 5;
            
            if( Number.isInteger(restPool / 4) )
            {
                let intResult = restPool / 4;
                poolTab["1"] = 5;
                poolTab[ intResult ] = 4;
            }
            else if( Number.isInteger(restPool / 6) )
            {
                let intResult = restPool / 6;
                poolTab["1"] = 5;
                poolTab[ intResult ] = 6;
            }
            else
            {
                restPool = nbrPlayer - 7;
                let intResult = restPool / 6;
                poolTab["1"] = 7;
                poolTab[ intResult ] = 6;
            }
            
            poolTab["variante"] = "unique";
            
            return poolTab;
        }
        else
        {
            let configTab = [ 3, 4, 5, 6, 7, 8 ];
            
            for( let i = 0; i <= configTab.length; i++ )
            {
                if( Number.isInteger( nbrPlayer / configTab[i] ) )
                {
                    let intResult = nbrPlayer / configTab[i];
                    poolTab[intResult] = configTab[i];
                }
            }
            
            return poolTab;
        }
    }   
    

//Test si un nombre est premier    
    nbrPremier(nbr) 
    {
      for(var i = 2; i < nbr; i++)
        if(nbr%i === 0) return false;
      return nbr > 1;
    }
    

//Fonction retournant une quantité de matchs selon un nombres de joueurs et suivant le processus d'élimination direct    
    howManyMatch( nbrPlayer )
    {
        let nbrP = parseInt(nbrPlayer, 10);
        let nbrMatchs = Math.ceil(nbrP/2); 
        while( nbrP > 2 )
        {
            if( nbrP == 10 )
            {
                return nbrMatchs += 13;
            }
            else if( nbrP == 3 )
            {
                return nbrMatchs + 4;
            }
            nbrP = Math.ceil(nbrP / 2);
            nbrMatchs += nbrP;
        }
        
        return nbrMatchs;
    }
    
    matchForLessThirteen( nbrPlayer )
    {
        let matchs = 0;
        let start = nbrPlayer - 1;
        let tabMatch = [];
        
        for( let i = start; i >= 1; i-- )
        {
            matchs += i;
            tabMatch.push(i);
        }
        
        return matchs;
    }
    
}

export default TournamentFunctions;