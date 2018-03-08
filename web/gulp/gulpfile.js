/*
 * @Author: paulloustaunau
 * @Date:   2017-01-14 19:00:31
 * @Last Modified by:   wehubAgency
 * @Last Modified time: 2017-08-05 09:34:26
 */


var gulp = require('gulp'),
    sass = require('gulp-sass'),
    jshint = require('gulp-jshint'),
    concat = require('gulp-concat'),
    imagemin = require('gulp-imagemin'),
    util = require('gulp-util'),
    fs = require('fs'),
    themes = require('./config/themes.json'),
    bs = require('browser-sync').create(),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    plumber = require('gulp-plumber'),
    stylish = require('jshint-stylish'),
    notify = require('gulp-notify'),
    cleanCSS = require('gulp-clean-css');

var config = require('./config/default.json');

gulp.task('sass', function() {

    gulp.src(config.src + '/css/src/**/main.scss')

    .pipe(plumber())
        //.pipe(sourcemaps.init())
        .pipe(sass())
        //.pipe(sourcemaps.write())
        .pipe(autoprefixer())
        .pipe(concat('style.css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest(config.src + '/'))
        .pipe(bs.reload({ stream: true }));
});


gulp.task('js', function() {

    gulp.src(config.src + '/js/src/**/*.js')
        .on('error', notify.onError(function(err) {
            return err.message;
        }))
        .pipe(plumber())
        .pipe(jshint())
        .pipe(jshint.reporter(stylish))
        .pipe(concat('app.js'))
        .pipe(gulp.dest(config.src + '/js'));
});

gulp.task('img', function() {

    gulp.src(config.src + '/images/src/**/*.{png,jpg,gif}')
        .pipe(imagemin({
            optimizationLevel: 7,
            progressive: true
        }))
        .pipe(gulp.dest(config.src + '/images/'));

});

gulp.task('watch', function() {

    console.log('Watch ' + config.src);

    gulp.watch(config.src + '/css/src/**/*.scss', ['sass']);
    gulp.watch(config.src + '/**.php').on('change', bs.reload);
    gulp.watch(config.src + '../src/**/*.html.twig').on('change', bs.reload);
    gulp.watch(config.src + '/assets/stylesheets/bootstrap/**.scss', ['sass']);
    gulp.watch(config.src + '/js/src/**/*.js', ['js']).on('change', bs.reload);
    gulp.watch(config.src + '/images/src/**/*.{png,jpg,gif}', ['img']).on('change', bs.reload);

});

gulp.task('dev', ['options', 'watch', 'browser-sync']);

gulp.task('options', function() {

    var config_t = themes[util.env.theme];

    if (config_t === undefined) {
        throw ('Error : theme ' + util.env.theme + ' not defined.');
    } else {
        if (!fs.existsSync(config_t.src)) { throw ('Error : directory ' + util.env.theme + ' not found.'); }
        config = config_t;
    }

    console.log('Theme : ' + util.env.theme);

});

gulp.task('browser-sync', function() {
    bs.init({
        proxy: "localhost",
        port: 8080
    });
});

function swallowError(error) {
    console.log(error.toString());
    this.emit('end');
}

var onError = function(err) {
    console.log(err.toString());
    this.emit('end');
};


gulp.task('default', ['options', 'sass', 'js']);
