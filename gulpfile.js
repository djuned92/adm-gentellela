var gulp		= require('gulp'),
	concat		= require('gulp-concat'),
	uglify		= require('gulp-uglify'),
	cleanCSS 	= require('gulp-clean-css');

gulp.task('css', function() {
	return gulp.src([
		'assets/plugins/bootstrap/dist/css/bootstrap.css',
		'assets/plugins/font-awesome/css/font-awesome.css',
		'assets/plugins/nprogress/nprogress.css',
		'assets/plugins/sweetalert/sweetalert.css',
		'assets/plugins/loader/loader.css',
		'assets/plugins/animate.css/animate.min.css',
		'assets/css/custom.min.css'
	])
	.pipe(cleanCSS())
	.pipe(concat('app.min.css'))
	.pipe(gulp.dest('assets/css'))
});

gulp.task('js', function() {
	return gulp.src([
		'assets/plugins/jquery/dist/jquery.min.js',
		'assets/plugins/bootstrap/dist/js/bootstrap.min.js',
		'assets/plugins/fastclick/lib/fastclick.js',
		'assets/plugins/nprogress/nprogress.js',
		'assets/plugins/jquery-validation/jquery.validate.min.js',
		'assets/plugins/sweetalert/sweetalert.min.js',
		'assets/js/custom.js'
	])
	.pipe(uglify())
	.pipe(concat('app.min.js'))
	.pipe(gulp.dest('assets/js'))
});

gulp.task('default', ['css','js']);