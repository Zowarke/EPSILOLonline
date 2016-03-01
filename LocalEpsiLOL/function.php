<script>
	var API_KEY = "a7103d78-47ef-4097-a41e-618b82276627";
	var summonerId;
	var version;
	var championName;
	/******************************** PAGE CHAMPIONS *******************************/
	function getChampionStatsBySummoner(sumID)
	{

		$.ajax({
			url: 'https://euw.api.pvp.net/api/lol/euw/v1.3/stats/by-summoner/' + sumID + '/ranked?season=SEASON2016&api_key=' + API_KEY,
			type: 'GET',
			dataType: 'json',
			data: {},
			success: function (json)
			{ 
				var numLigne = 1;
				$.each(json.champions,	
					function(id, stats)
					{
						if(stats.id != 0)
						{
							getChampionNameByChampionIdAndDisplayTable(stats.id,stats.stats["totalSessionsPlayed"], stats.stats["totalSessionsWon"], stats.stats["totalSessionsLost"], (stats.stats["totalSessionsWon"]/stats.stats["totalSessionsPlayed"]*100).toFixed(1), (stats.stats["totalChampionKills"]/stats.stats["totalSessionsPlayed"]).toFixed(1), (stats.stats["totalDeathsPerSession"]/stats.stats["totalSessionsPlayed"]).toFixed(1), (stats.stats["totalAssists"]/stats.stats["totalSessionsPlayed"]).toFixed(1), ((stats.stats["totalChampionKills"] + stats.stats["totalAssists"])/stats.stats["totalDeathsPerSession"]).toFixed(2), (stats.stats["totalMinionKills"]/stats.stats["totalSessionsPlayed"]).toFixed(0), (stats.stats["totalGoldEarned"]/stats.stats["totalSessionsPlayed"]).toFixed(0));

							numLigne++;
						}
					}
					)
			},

			error: function (XMLHttpRequest, textStatus, errorThrown) 
			{
				alert("error getting Summoner data!");
			}
		});

}


function getChampionNameByChampionIdAndDisplayTable(championID, nbGame, nbWon, nbLost, pourcentage, kill, death, assist, kda, cs, gold)
{
	$.ajax({
		url: 'https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion/'+championID+'?champData=all&api_key='+ API_KEY,
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (json)
		{ 
			var numLigne = 1;
			image = json.image.full;
			name = json["name"];
			$("#championTable").DataTable().row.add([
				'<img style="width:45%" src="http://ddragon.leagueoflegends.com/cdn/'+version+'/img/champion/'+image+'" class="img-circle">',
				name,
				nbGame,
				nbWon,
				nbLost,
				pourcentage + '%',
				kill,
				death,
				assist,
				kda,
				cs,
				gold
				]).draw();
		},

		error: function (XMLHttpRequest, textStatus, errorThrown) 
		{
			alert("error getting Summoner data!");
		}
	});

		//Cette dernière fonction récupère tous les paramètres passés par la précédente. A savoir tous les stats des parties en fonction de chaque héros.
		//Cette façon de faire est obligatoire car une fonction success json ne peut pas retourner de réponse.
	}

	function getSummonerIdBySummonerName(SUMMONER_NAME)
	{
		if (SUMMONER_NAME !== "") 
		{
			$.ajax({
				url: 'https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/by-name/' + SUMMONER_NAME + '?api_key=' + API_KEY,
				type: 'GET',
				dataType: 'json',
				data: {},
				success: function (json)
				{ 	
					var SUMMONER_NAME_NOSPACES = SUMMONER_NAME.replace(" ", "");
					SUMMONER_NAME_NOSPACES = SUMMONER_NAME_NOSPACES.toLowerCase().trim();
					sumID = json[SUMMONER_NAME_NOSPACES].id;
					getChampionStatsBySummoner(sumID);


				},

				error: function (XMLHttpRequest, textStatus, errorThrown) 
				{
					alert("error getting Summoner data!");
				}
			});
		}
	}

	function getVersion()
	{
		$.ajax({
			url: 'https://global.api.pvp.net/api/lol/static-data/euw/v1.2/versions?api_key='+API_KEY,
			type: 'GET',
			dataType: 'json',
			data: {},
			success: function (json)
			{ 
				version = json[0];
			}	

		});

	}

	/******************************** PAGE SUMMARY *******************************/


	var handleGame = function(key, value){

		switch(value.subType){
			case "RANKED_SOLO_5x5":
			gameType="Ranked Solo 5x5"
			break;
			case "RANKED_TEAM_5x5":
			gameType="Ranked Team 5x5"
			break;
			case "RANKED_TEAM_3x3":
			gameType="Ranked Team 3x3"
			break;
			case "NONE":
			gameType="Custom"
			break;
			case "NORMAL":
			gameType="Normal"
			break;
			case "BOT":
			gameType="Bot"
			break;
			case "RANKED_PREMADE_3x3":
			gameType="Ranked Premade 3x3"
			break;
			case "RANKED_PREMADE_5x5":
			gameType="Ranked Premade 5x5"
			break;
			case "ODIN_UNRANKED":
			gameType="Odin Unranked"
			break;
			case "NORMAL_3x3":
			gameType="Normal 3x3"
			break;
			case "BOT_3x3":
			gameType="Bot 3x3"
			break;
			case "CAP_5x5":
			gameType="Team Builder 5x5"
			break;
			case "ARAM_UNRANKED_5x5":
			gameType="Aram 5x5"
			break;
			case " ONEFORALL_5x5":
			gameType="One For All 5x5"
			break;
			case "FIRSTBLOOD_1x1":
			gameType="FirstBlood 1x1"
			break;
			case "FIRSTBLOOD_2x2":
			gameType="FirstBlood 2x2"
			break;
			case "SR_6x6":
			gameType="SR 6x6"
			break;
			case "URF":
			gameType="URF"
			break;
			case "URF_BOT":
			gameType="URF Bot"
			break;
			case "NIGHTMARE_BOT":
			gameType="Nightmare Bot"
			break;
			case "ASCENSION":
			gameType="Ascension"
			break;
			case "HEXAKILL":
			gameType="Hexakill"
			break;
			case "KING_PORO":
			gameType="Poro King"
			break;
			case "COUNTER_PICK":
			gameType="Counter Pick"
			break;
			case "BILGEWATER":
			gameType="Bilgewater"
			break;


		}
		if(value.stats["championsKilled"])
		{
			championsKilled = value.stats["championsKilled"];
		}
		else{
			championsKilled = 0;
		}


		if(value.stats["numDeaths"])
		{
			deaths = value.stats["numDeaths"];
		}
		else{
			deaths = 0;
		}


		if(value.stats["assists"])
		{
			assists = value.stats["assists"];
		}
		else{
			assists = 0;
		}
		win = value.stats["win"];
		cs = value.stats["minionsKilled"];
		getChampionNameAndChampionImageByChampionId(value.championId, key, gameType, championsKilled, deaths, assists, win, cs);

	}

	function getRecentGameInfo(sumID)
	{
		$.ajax({
			url: 'https://euw.api.pvp.net/api/lol/euw/v1.3/game/by-summoner/'+sumID+'/recent?api_key='+API_KEY,
			type: 'GET',
			dataType: 'json',
			data: {},
			success: function (json)
			{ 
				for(var i=0; i<8; i++){
					handleGame(i,json.games[i] );

				}



			}	

		});
	}

	function getChampionNameAndChampionImageByChampionId(championId, numGame, gameType, championsKilled, deaths, assists, win, cs)
	{
		$.ajax({
			url: 'https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion/'+championId+'?champData=all&api_key='+ API_KEY,
			type: 'GET',
			dataType: 'json',
			data: {},
			success: function (json)
			{ 
				image = json.image.full;
				championName = json["name"];
				if (win == true)
				{

					document.getElementById("recentGame").innerHTML += "<div class='col-md-4'><div class='box box-widget widget-user'><div style='background-color:#00a65a' class='widget-user-header bg-aqua-active'><h3 class='widget-user-username'>"+gameType+"</h3><h5 class='widget-user-desc'>"+championName+"</h5></div><div class='widget-user-image'><img class='img-circle' src='http://ddragon.leagueoflegends.com/cdn/"+version+"/img/champion/"+image+"'></div><div class='box-footer'><div class='row'><div class='col-sm-4 border-right'><div class='description-block'><span class='description-text'>K/D/A</span><h5 class='description-header'>"+championsKilled+"/"+deaths+"/"+assists+"</h5></div></div><div class='col-sm-4 border-right'><div class='description-block'><h5 class='description-header'>VICTORY</h5></div></div><div class='col-sm-4'><div class='description-block'><span class='description-text'>CS</span><h5 class='description-header'>"+cs+"</h5></div></div>";
				}
				else
				{

					document.getElementById("recentGame").innerHTML += "<div class='col-md-4'><div class='box box-widget widget-user'><div style='background-color:#dd4b39' class='widget-user-header bg-aqua-active'><h3 class='widget-user-username'>"+gameType+"</h3><h5 class='widget-user-desc'>"+championName+"</h5></div><div class='widget-user-image'><img class='img-circle' src='http://ddragon.leagueoflegends.com/cdn/"+version+"/img/champion/"+image+"'></div><div class='box-footer'><div class='row'><div class='col-sm-4 border-right'><div class='description-block'><span class='description-text'>K/D/A</span><h5 class='description-header'>"+championsKilled+"/"+deaths+"/"+assists+"</h5></div></div><div class='col-sm-4 border-right'><div class='description-block'><h5 class='description-header'>DEFEAT</h5></div></div><div class='col-sm-4'><div class='description-block'><span class='description-text'>CS</span><h5 class='description-header'>"+cs+"</h5></div></div>";
				}

			}
		});

}

</script>	