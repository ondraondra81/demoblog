$.texyla.setDefaults({
	baseDir: '/js/texyla',
	previewPath: '{{$previewPath}}',
	filesPath: '{{$filesPath}}',
	filesUploadPath: '{{$filesUploadPath}}',
	filesMkDirPath: '{{$filesMkDirPath}}',
	filesRenamePath: '{{$filesRenamePath}}',
	filesDeletePath: '{{$filesDeletePath}}'
});

$(function () {
	$(".texyla").texyla({
		toolbar: [
			'h1', 'h2', 'h3', 'h4',
			null,
			'bold', 'italic',
			null,
			'center', ['left', 'right', 'justify'],
			null,
			'ul', 'ol', ["olAlphabetSmall", "olAlphabetBig", "olRomans", "olRomansSmall"],
			null,
			'link', 'img', 'table', 'emoticon', 'symbol',
			null,
			'color', 'textTransform',
			null,
			'files', 'youtube', 'gravatar',
			null,
			'div', ['html', 'blockquote', 'text', 'comment'],
			null,
			'code',	'codeHtml', 'codeCss', 'codeJs', 'codePhp', 'codeSql', 'codeInline',
			null,
			'sup', 'sub', 'del', 'acronym', 'hr', 'notexy'

		],
		texyCfg: "admin",
		bottomLeftToolbar: ['edit', 'preview', 'htmlPreview'],
		buttonType: "span",
		tabs: true
	});

	$.texyla({
		buttonType: "button"
	});

});