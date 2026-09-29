/**
 * Museo Postal: mejora progresiva del bloque museopostal/video.
 * Sin este fichero el enlace abre el reproductor de youtube-nocookie.com;
 * con él, el clic incrusta el vídeo en la misma página.
 */
document.addEventListener( 'click', function ( evento ) {
	var enlace = evento.target.closest( 'a[data-mp-video]' );
	if ( ! enlace ) {
		return;
	}
	evento.preventDefault();
	var marco = document.createElement( 'iframe' );
	marco.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent( enlace.getAttribute( 'data-mp-video' ) ) + '?autoplay=1';
	marco.title = enlace.getAttribute( 'data-mp-titulo' ) || 'Vídeo';
	marco.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen';
	marco.setAttribute( 'allowfullscreen', '' );
	enlace.replaceWith( marco );
	marco.focus();
} );
