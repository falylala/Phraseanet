var gulp = require('gulp');
var config = require('../config.js');
var utils = require('../utils.js');

gulp.task('copy-thesaurus-images', function(){
    return gulp.src([config.paths.src + 'thesaurus/images/**/*'])
        .pipe(gulp.dest( config.paths.build + 'thesaurus/images'));
});
gulp.task('build-thesaurus-css', function(){
    return utils.buildCssGroup([
        config.paths.src + 'thesaurus/styles/main.scss'
    ], 'thesaurus', 'thesaurus/css/');
});

gulp.task('build-thesaurus', ['copy-thesaurus-images', 'build-thesaurus-css'], function(){
    var thesaurusGroup = [
        config.paths.dist + 'skins/thesaurus/win.js',
        config.paths.dist + 'skins/thesaurus/xmlhttp.js',
        config.paths.dist + 'skins/thesaurus/thesaurus.js',
        config.paths.dist + 'skins/thesaurus/sprintf.js'
    ];
    return utils.buildJsGroup(thesaurusGroup, 'thesaurus', 'thesaurus/js');
});