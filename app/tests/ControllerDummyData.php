<?php

/**
 * Provides an array of data used in a Catalogue document
 */
function getCatalogueTestData(){
	return array(
		'show', //type
		'deleteme1993getmeajobatcrunchyroll', //title
		'nope', //picture
		[], //videos
		'1994', //years
		'TV-14', //guidanceRating
		'A date in time', //releaseDate
		'22 min', //duration
		'Comedy', //genres
		'Courtney Cox', //people
		'Stuff and words.', //plotShort
		'Long Stuff and words, to the sky and infinity and beyond, but there\'s a snack in my boot.', //plotLong
		'USA', //countryOfOrigin
		'Some big stuff' //awards
	);
}

/**
 * Provides an array of data used in a Badge document
 */
function getBadgeTestData(){
	return array(
			"N/A", //image 
			"LoserBadge1234Hax", //name
			"Condition format to be defined", //condition
			2 //numAwards given
		);
}

/**
 * Provides an array of data used in a Character document
 */
function getCharacterTestData(){
	return array(
		'N/A',
		'Eggy Junior III',
		[],
		[],
		[],
		'Some sort of description'
	);
}

/**
 * Provides an array of data used in a Company document
 */
function getCompanyTestData(){
	return array(
		'N/A',
		'SuperExclusiveMovieStudio',
		'Licensing',
		['filmography']
	);
}

/**
 * Provides an array of data used in a Message document
 */
function getMessageTestData(){
	$currentDate = date("m.d.y");
	return array(
		'sender',
		'receiver',
		"$currentDate", //dateSent
		"$currentDate", //dateReceived
		'subject',
		'content',
		'isSeen'
	);
}

/**
 * Provides an array of data used in a Person document
 */
function getPersonTestData(){
	$currentDate = date("m.d.y");
	return array(
		'N/A',
		'Andrew',
		'Vorakrajangthiti',
		"$currentDate",
		'A loser.',
		[],
		[],
		'Co-lead developer, I think.',
		[]
	);
}

/**
 * Provides an array of data used in an Account document
 */
function getUserTestData(){
	$currentDate = date('m.d.y');
	return array(
			'billyjoebob1290349difjdkf', //username
			false, //isAdmin
			'bj@fake.com', //email
			'billy', //firstName
			'joelbob', //lastName
			'male', //gender
			"$currentDate" //birthday
		);
}

/**
 * Provides an array of data used in a UserData document
 */
function getUserDataTestData(){
	return array(
		'billyjoebob1290349difjdkf' //username
	);
}

?>