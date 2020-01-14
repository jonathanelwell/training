function training_plan_week_save( week_form )
{
	console.log( week_form.serialize() );
	$.post( "/training_plan_week/update", $(week_form).serialize(), function( results )
	{
		console.log( results );
	});
}
function workout_create( date )
{
	$.get( "/workout/create?date=" + date, function( results )
	{
		$( "#workout_dialog .modal-body" ).html( results );
		$('#workout_dialog').modal({show:true});
	});
}
function workout_edit( id )
{
	$.get( "/workout/" + id + "/edit", function( results )
	{
		$( "#workout_dialog .modal-body" ).html( results );
		$('#workout_dialog').modal({show:true});
	});
}
function workout_save(id)
{
	if( id == "undefined" || id == null || id == "" )
	{
		var url = "/workout";
	}
	else
	{
		var url = "/workout/" + id;
	}
	
	$.ajax
	({ 
		url: url,
		type: "POST",
		data: new FormData( document.getElementById('workout_form') ),
		headers: { 'X-CSRF-TOKEN': $('#workout_form [name="_token"]').val()},
		contentType: false,
		cache: false,
		processData: false,
		complete: function( results )
		{
			$( "#workout_dialog .modal-body" ).html( results.resultText );
			setTimeout(function(){ $('#workout_dialog').modal("hide"); }, 1000);
		}
	});
}
function workouts_import()
{
	var import_form = document.getElementById('form_workout_import');
	var import_form_data = new FormData(import_form);
	
	//submits the ticket
	$.ajax
	({ 
		url: "/workout/import",
		data: import_form_data,
		processData: false,
		contentType: false,
		type: 'POST',
		success: function( result )
		{
			console.log("RESULTS\n");
			console.log( result );
			console.log( "END\n" );
		}
	});
}
function workout_delete(id)
{
	$.ajax
	({ 
		url: "/workout/" + id,
		type: "DELETE",
		complete: function( results )
		{
			$( "#workout_dialog .modal-body" ).html( results.resultText );
			setTimeout(function(){ $('#workout_dialog').modal("hide"); }, 1000);
		}
	});
}