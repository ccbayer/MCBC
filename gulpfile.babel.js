'use strict';

import gulp from 'gulp';
import gulpLoadPlugins from 'gulp-load-plugins';
import browserSync from 'browser-sync';
import del from 'del';
import merge from 'merge-stream';
import {stream as wiredep} from 'wiredep';
import rubySass from 'gulp-ruby-sass';

const $ = gulpLoadPlugins();
const basePath = './wp-content/themes/MCBC-Colin';
const reload = browserSync.reload;

gulp.task('styles', function () {
	gulp.src('./src/styles/*.scss')
	  .pipe($.sourcemaps.init())
	  .pipe($.sass.sync({
      outputStyle: 'expanded',
      precision: 10,
      includePaths: ['.', './bower_components/bootstrap-sass/assets/stylesheets/', './bower_components/sass-mediaqueries/', './bower_components/slick-carousel/']
    }).on('error', $.sass.logError))
	.pipe($.autoprefixer({browsers: ['last 4 versions']}))
    .pipe($.sourcemaps.write())
	.pipe(gulp.dest('./'));
});


gulp.task('sass', function () {
	return rubySass('./src/styles/*.scss', {
		sourcemap: true,
		precision: 10,
		style: 'expanded',
		loadPath: ['.', './bower_components/bootstrap-sass/assets/stylesheets/', './bower_components/sass-mediaqueries/', './bower_components/slick-carousel/slick']
	}).on('error', rubySass.logError)
	   // For inline sourcemaps
		 .pipe($.autoprefixer({browsers: ['last 4 versions']}))
    .pipe($.sourcemaps.write())
    .pipe(gulp.dest('./'));
});

gulp.task('sass-build', function () {
	return rubySass('./src/styles/*.scss', {
		sourcemap: false,
		precision: 10,
		style: 'compressed',
		loadPath: ['.', './bower_components/bootstrap-sass/assets/stylesheets/', './bower_components/sass-mediaqueries/', './bower_components/slick-carousel/slick']
	}).on('error', rubySass.logError)
	.pipe($.autoprefixer({browsers: ['last 4 versions']}))
    .pipe(gulp.dest('./'));
});


gulp.task('bower', function () {
  gulp.src('./src/footer.php')
    .pipe(wiredep())
    .pipe(gulp.dest('./'));
});

gulp.task('sprites', function() {
var spriteData = gulp.src('./images/sprites/*.png')
    .pipe($.spritesmith({
      imgName: 'sprite.png',
      imgPath: './images/sprite.png',
      cssName: '_sprites.scss'
  }));
    var imgStream = spriteData.img
    .pipe(gulp.dest('./images/'));

  var cssStream = spriteData.css
    .pipe(gulp.dest('./src/styles/partials'));

  return merge(imgStream, cssStream);

});

gulp.task('useref', function () {
  gulp.src('./src/scripts.html')
  	.pipe($.useref())
    .pipe($.if('*.js', $.uglify()))
    .pipe(gulp.dest('./'));
});

gulp.task('watch', ['sprites', 'sass', 'useref'], function() {

	gulp.watch([
		'./src/styles/**/*.scss'
	]).on( 'change', reload);

	/** Watch for autoprefix */
	gulp.watch( [
		'./src/styles/**/*.scss'
	], [ 'sass' ] );

	/** Watch for autoprefix */
	gulp.watch( [
		'./src/js/**/*.js'
	], [ 'useref' ] );

		/** Watch for autoprefix */
	gulp.watch( [
		'./images/sprites/*.png'
	], [ 'sprites' ] );

});
