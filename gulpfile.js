const gulp = require('gulp');
const cleanCSS = require('gulp-clean-css');
const concat = require('gulp-concat');
const less = require('gulp-less');
const path = require('path');

// Less task 
gulp.task('less', function () {
  return gulp.src('./src/less/**/*.less')
    .pipe(less({
      paths: [ path.join(__dirname, 'src/less', 'includes') ]
    }))
    .pipe(cleanCSS({level: 2}))
    .pipe(gulp.dest('./build/css'));
});

// Js modules
const uglify = require('gulp-uglify');
const pump = require('pump');
 
gulp.task('compress', function (cb) {
  pump([
        gulp.src('./src/js/**/*.js'),
        uglify(),
        pipe(gulp.dest('./build/js'))
    ],
    cb
  );
});


function watch(){
	gulp.watch('less', less);
	gulp.watch('compress', compress);
}
// CSS files
function stylesCsss() {
  return gulp.src('./src/css/**/*.css')
  			 .pipe(concat('all.css'))
  			 .pipe(gulp.dest('./build/css'));
}

// JS files
function scriptJs() {
  return gulp.src('./src/js/**/*.js')
  			 .pipe(gulp.dest('./build/js'));
}

gulp.task('css', stylesCsss);
gulp.task('js', scriptJs);

module.exports.watch = watch;