<?php

//Author		: de77
//Website		: www.de77.com
//License		: MIT (http://en.wikipedia.org/wiki/MIT_License)
//Class desc	: http://de77.com/php/php-class-how-to-read-id3-v1-tag-from-mp3-files

//------------------------------------------------------------------------------
//          If you like this class- please leave a comment on my site, thanks!
//------------------------------------------------------------------------------

class Id3
{	
	public $error;
	
	private $genres = array(
		'Blues',
		'Classic Rock',
		'Country',
		'Dance',
		'Disco',
		'Funk',
		'Grunge',
		'Hip-Hop',
		'Jazz',
		'Metal',
		'New Age',
		'Oldies',
		'Other',
		'Pop',
		'R&B',
		'Rap',
		'Reggae',
		'Rock',
		'Techno',
		'Industrial',
		'Alternative',
		'Ska',
		'Death Metal',
		'Pranks',
		'Soundtrack',
		'Euro-Techno',
		'Ambient',
		'Trip-Hop',
		'Vocal',
		'Jazz+Funk',
		'Fusion',
		'Trance',
		'Classical',
		'Instrumental',
		'Acid',
		'House',
		'Game',
		'Sound Clip',
		'Gospel',
		'Noise',
		'AlternRock',
		'Bass',
		'Soul',
		'Punk',
		'Space',
		'Meditative',
		'Instrumental Pop',
		'Instrumental Rock',
		'Ethnic',
		'Gothic',
		'Darkwave',
		'Techno-Industrial',
		'Electronic',
		'Pop-Folk',
		'Eurodance',
		'Dream',
		'Southern Rock',
		'Comedy',
		'Cult',
		'Gangsta',
		'Top 40',
		'Christian Rap',
		'Pop/Funk',
		'Jungle',
		'Native American',
		'Cabaret',
		'New Wave',
		'Psychadelic',
		'Rave',
		'Showtunes',
		'Trailer',
		'Lo-Fi',
		'Tribal',
		'Acid Punk',
		'Acid Jazz',
		'Polka',
		'Retro',
		'Musical',
		'Rock & Roll',
		'Hard Rock',
		'Folk',
		'Folk-Rock',
		'National Folk',
		'Swing',
		'Fast Fusion',
		'Bebob',
		'Latin',
		'Revival',
		'Celtic',
		'Bluegrass',
		'Avantgarde',
		'Gothic Rock',
		'Progressive Rock',
		'Psychedelic Rock',
		'Symphonic Rock',
		'Slow Rock',
		'Big Band',
		'Chorus',
		'Easy Listening',
		'Acoustic',
		'Humour',
		'Speech',
		'Chanson',
		'Opera',
		'Chamber Music',
		'Sonata',
		'Symphony',
		'Booty Bass',
		'Primus',
		'Porn Groove',
		'Satire',
		'Slow Jam',
		'Club',
		'Tango',
		'Samba',
		'Folklore',
		'Ballad',
		'Power Ballad',
		'Rhythmic Soul',
		'Freestyle',
		'Duet',
		'Punk Rock',
		'Drum Solo',
		'Acapella',
		'Euro-House',
		'Dance Hall'
		);
	
	public function read($file)
	{
		$f = fopen($file, 'r');
		fseek($f, -128, SEEK_END);
		$id3 = fread($f, 128);
		fclose($f);
		
		$id3 = @unpack("a3signature/a30title/a30artist/a30album/a4year/a30comment/c1genre", $id3);
		$id3['genre'] = @$this->genres[$id3['genre']];
		
		if (!$id3['signature'] == 'TAG')
		{
			$this->error = 'This file does not contain ID3 v1 tag';		
			return false;		
		}
		
		unset($id3['signature']);
  		return $id3;	
	}	
}