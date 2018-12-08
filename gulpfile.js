const gulp = require('gulp');
const cleanCSS = require('gulp-clean-css');
const sass = require('gulp-sass');
const path = require('path');
const imagemin = require('gulp-imagemin');
const pngquant = require('imagemin-pngquant');
const uglify = require('gulp-uglify-es').default;
const concat = require('gulp-concat');
const browserSync = require('browser-sync');

// Sass task 
function sassCript() {
  return gulp.src('./src/sass/**/*.scss')
    .pipe(sass())
    .pipe(cleanCSS({level: 2}))
    .pipe(gulp.dest('./build/css'));
}

// Js files
const jsFiles = [
    './src/js/includes/jquery.js',
    './src/js/includes/bootstrap.min.js',
    './src/js/includes/sort.js',
    './src/js/includes/source.js',
    './src/js/main.js'
];

// Js task
function jsCript() {
  return gulp.src(jsFiles)
    .pipe(concat('all.js'))
    /*.pipe(uglify({
      toplevel: true
    }))*/
    .pipe(gulp.dest('./build/js'));
}

// Compress images 
function images() {
    return gulp.src('./src/img/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(gulp.dest('./build/img'))
        .pipe(browserSync.stream());
}

// Watch and server
function serve(){
    gulp.watch('./src/sass/**/*.scss', sassCript);
    gulp.watch('./src/js/**/*.js', jsCript);
    gulp.watch('./src/img/*', images);
}


gulp.task('default', serve);