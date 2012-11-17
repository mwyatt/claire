/*
Table Tennis League Scripts
Author: Martin Wyatt
*/

// $j
$j = jQuery.noConflict();

/* *****************************************************************
EDIT VENUE, TEAM, PLAYER
***************************************************************** */

/* all */

	// edit
    function editPanel(type,id,name)
    {
	// type = venue, team, player
	// id = 1, 2, ...
	// name = Burnley Boys Club
	
	  // reset panel
	  $j("td.edit-panel").detach();
	  $j("table.general td").show();
	  
	  if ( type == 'venue' ) {
	  
	    // form var
	    var address = $j("tr."+type+"_"+id+" .btn_admin.map").attr("title");
	    
		// hide cell
	    $j("tr."+type+"_"+id+" td").toggle();
	    
	    // append new class to tr? class="mode_edit"
	    $j("tr."+type+"_"+id).toggleClass( "edit-mode", true );
	    // append edit form
	    $j("tr."+type+"_"+id).append('<td class="edit-panel" colspan="2"><form method="post"><div class="btn-close"></div><input type="hidden" name="edit-venue" value="'+id+'" /><div><input id="name" type="text" name="name" size="20" maxlength="35" value="'+name+'" /><input id="address" type="text" name="address" size="20" value="'+address+'" /></div><div align="right"><input type="submit" class="btn-primary" value="Save" /></div></form></td>');
	  
	  }

	  if ( type == 'team' ) {
	  
	    // form var
	    //var homenight = $j("tr."+type+"_"+id+" .home_night").html();
	    
		// hide cell
	    $j("tr."+type+"_"+id+" td").toggle();
	    
	    // append new class to tr? class="mode_edit"
	    $j("tr."+type+"_"+id).toggleClass( "edit-mode", true );
	    // append edit form
		
		var row = $j("tr."+type+"_"+id);
		var cell = $j("tr."+type+"_"+id+" td");
		
	    // append edit form
	    $j("tr."+type+"_"+id).append('<td class="edit-panel" colspan="5"><form method="post"><div class="btn-close"></div><input type="hidden" name="edit-team" value="'+id+'" /><div><input id="name" type="text" name="name" size="20" maxlength="35" value="'+name+'" /><div align="right"><input type="submit" class="btn-primary" value="Save" /></div></form></td>');
	  
	  }

	  if ( type == 'player' ) {
	  
	    // form var
	    var rank = $j("tr."+type+"_"+id+" .rank").html();
	    
		// hide cell
	    $j("tr."+type+"_"+id+" td").toggle();
	    
	    // append new class to tr? class="mode_edit"
	    $j("tr."+type+"_"+id).toggleClass( "edit-mode", true );
	    // append edit form
		
		var row = $j("tr."+type+"_"+id);
		var cell = $j("tr."+type+"_"+id+" td");
		
	    // append edit form
	    $j("tr."+type+"_"+id).append('<td class="edit-panel" colspan="6"><form method="post"><div class="btn-close"></div><input type="hidden" name="edit-player" value="'+id+'" /><div><input id="rank" type="text" name="rank" size="4" maxlength="10" value="'+rank+'" /><div align="right"><input type="submit" class="btn-primary" value="Save" /></div></form></td>');
	  
	  }

	  // cancel edit
	  $j(".general .btn-close").click(function(){
	  // get id and hide td's
	  $j("tr.venue_"+id+" td").toggle();
	  $j("tr.team_"+id+" td").toggle();
	  $j("tr.player_"+id+" td").toggle();
	  $j("td.edit-panel").detach();
	  });
	  
	  // disable submit button once submitted
	  $j('form').submit(function(){
	 	 $j('input[type=submit]', this).attr('disabled', 'disabled');
	  });
	  
	};
	
/* *****************************************************************
DELETE VENUE, TEAM, PLAYER
***************************************************************** */

// delete anything
  function deleteConfirm(type,id,name)
  {  
    smoke.confirm("Delete "+type+" "+name+"?",function(e){
      if (e){
        var url=document.URL+"&delete_"+type+"="+id;
        window.open(url, "_self")
      }else{
        // do nothing.
      }
    }, {ok:"YES", cancel:"NO"});
  }

/* *****************************************************************
ASSIGN TEAM, PLAYER
***************************************************************** */

/*

smoke.signal('<select onchange="assign(type,id,name)" name="division"><option value="0">Division</option><option value="1">Premier Division</option><option value="2">First Division</option><option value="3">Second Division</option><option value="4">Third Division</option></select>');


*/

// assign anything
  function assign(type,id,name)
  {  
    var url=document.URL+"&assign_"+type+"="+id;
      window.open(url, "_self")
  }

  
  
  
// document ready
$j(document).ready(function(){

/* *****************************************************************
UNIVERSAL
***************************************************************** */

// disable submit button
$j('form').submit(function(){
	$j('input[type=submit]', this).attr('disabled', 'disabled');
});

/* new panel */	

// new
$j("#wrap-add_new #btn-add_new").click(function(){
  $j(this).toggle();
  $j("#wrap-add_new form").toggle();  
});
  // cancel
  $j("#wrap-add_new .btn-close").click(function(){
    $j("#wrap-add_new #btn-add_new").toggle();
    $j("#wrap-add_new form").toggle();  
  });



/* *****************************************************************
SUBMIT RESULTS
***************************************************************** */	

$j('[class="field-team"]').change(function(){
	$j('[title="Play Up"]').removeClass('hidden');
});

// Play Up
$j('.play-up').click(function(){
    $j(this).addClass('hidden');
    $j(this)
    	.closest('div')
    	.find('select')
    	.html($j('[name="play-up"]').html());
});	

// JS function - <select - Away Team>
function SetAwayTeam( chosen_home, chosen_away ) {
  reset_home = document.getElementById( "home_team" );
  if (chosen_home == chosen_away) {
  	reset_home.value="0";
  }
}


// Field Player onchange
$j(".field-player").change(function(){

  // clear scores
  //$j(".field-match_score").val("");

  // which player is this?
  id = $j(this).attr("id");
  val = $j(this).val();
  PlayerName = $j("#"+id+" option[value="+val+"]").text();
  
  // set label
  if ( val !== "0" ) {
    $j("."+id+"-label").text(PlayerName);
  } else {
    $j("."+id+"-label").text("");
  }
  
  // is player == other player?
  // insert code here like team one..
 
});

	// Field Match Score keyup
	$j(".field-match_score").keyup(function(){
	
		$j(".field-match_score").click(function(){
		  // select all
		  $j(this).select();
		});	
	
	  // set vars
	  vclass = $j(this).attr("class");
	  val = $j(this).val();
	
	  if ( val < 3 && val !== '' ) {

	    if ( $j(this).hasClass("home") == true ) {
		    // which match?
			if ( $j(this).hasClass("match_1") == true ) {
			  $j("[name='match_1-away']").val(3);
			}
			if ( $j(this).hasClass("match_2") == true ) {
			  $j("[name='match_2-away']").val(3);
			}
			if ( $j(this).hasClass("match_3") == true ) {
			  $j("[name='match_3-away']").val(3);
			}
			if ( $j(this).hasClass("match_4") == true ) {
			  $j("[name='match_4-away']").val(3);
			}
			if ( $j(this).hasClass("match_5") == true ) {
			  $j("[name='match_5-away']").val(3);
			}
			if ( $j(this).hasClass("match_d") == true ) {
			  $j("[name='match_d-away']").val(3);
			}
			if ( $j(this).hasClass("match_6") == true ) {
			  $j("[name='match_6-away']").val(3);
			}
			if ( $j(this).hasClass("match_7") == true ) {
			  $j("[name='match_7-away']").val(3);
			}
			if ( $j(this).hasClass("match_8") == true ) {
			  $j("[name='match_8-away']").val(3);
			}
			if ( $j(this).hasClass("match_9") == true ) {
			  $j("[name='match_9-away']").val(3);
			}
	    } else {
		    // which match?
			if ( $j(this).hasClass("match_1") == true ) {
			  $j("[name='match_1-home']").val(3);
			}
			if ( $j(this).hasClass("match_2") == true ) {
			  $j("[name='match_2-home']").val(3);
			}
			if ( $j(this).hasClass("match_3") == true ) {
			  $j("[name='match_3-home']").val(3);
			}
			if ( $j(this).hasClass("match_4") == true ) {
			  $j("[name='match_4-home']").val(3);
			}
			if ( $j(this).hasClass("match_5") == true ) {
			  $j("[name='match_5-home']").val(3);
			}
			if ( $j(this).hasClass("match_d") == true ) {
			  $j("[name='match_d-home']").val(3);
			}
			if ( $j(this).hasClass("match_6") == true ) {
			  $j("[name='match_6-home']").val(3);
			}
			if ( $j(this).hasClass("match_7") == true ) {
			  $j("[name='match_7-home']").val(3);
			}
			if ( $j(this).hasClass("match_8") == true ) {
			  $j("[name='match_8-home']").val(3);
			}
			if ( $j(this).hasClass("match_9") == true ) {
			  $j("[name='match_9-home']").val(3);
			}	
		}
		
	  } else if ( val == 3 ) {		
		
	  } else {
	    $j(this).val('');
	  }
	  
		  // calculate home_score
		  var sum = 0;
		  // loop through each textbox and add the val
		  $j(".home").each(function() {
		  
			// add only if the value is number
			if(!isNaN( $j(this).val() ) && $j(this).val() != 0 ) {
				sum += parseFloat( $j(this).val() );
			}
		  
		  });
		  // update home_score
		  $j(".home_score").html(sum);
		  $j("[name='home_score']").attr("value",sum);
		
		  // calculate away_score
		  var sum = 0;
		  // loop through each textbox and add the val
		  $j(".away").each(function() {
		  
			// add only if the value is number
			if(!isNaN( $j(this).val() ) && $j(this).val() != 0 ) {
				sum += parseFloat( $j(this).val() );
			}
		  
		  });
		  // update home_score
		  $j(".away_score").html(sum);
		  $j("[name='away_score']").attr("value",sum);
		
	});	
	
	
	
	


}); // end