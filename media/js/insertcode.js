(function()
{
	"use strict";

	document.addEventListener('DOMContentLoaded', function()
	{
		var form = document.getElementById('PAGEBREAKGHSVS');
		var tag, title, title2, slidersEnd;

		document.getElementById('insertPagebreakGhsvsCode').addEventListener('click', function()
		{
			if (!window.parent.Joomla.getOptions('xtd-pagebreakghsvs'))
			{
				// Something went wrong!
				if (window.parent.Joomla.Modal)
				{
					// Joomla 4
					window.parent.Joomla.Modal.getCurrent().close();
				}
				else
				{
					// Joomla 3
					window.parent.jModalClose();
				}
				return false;
			}

			var editor = window.parent.Joomla.getOptions('xtd-pagebreakghsvs').editor;

			var formData = {};

			for (var i = 0; i < form.elements.length; i++)
			{
				var e = form.elements[i];

				if (e.name)
				{
					if (e.name === 'slidersEnd')
					{
						formData[e.name] = e.checked;
					}
					else
					{
						formData[e.name] = e.value;
					}
				}
			}
			
			title = formData.title;
			title2 = formData.title2;
			
			if (!formData.slidersEnd)
			{
				title = title.replace(/\"/g, '`');
				title2 = title2.replace(/\"/g, '`');
				slidersEnd = "";
				title = ' title="' + title + '"';
				title2 = ' title2="' + title2 + '"';
			}
			else
			{
				slidersEnd = ' slidersEnd="1"';
				title = "";
				title2 = "";
			}

			//uid = ' uid="id' + (new Date()).getTime() + '"';

			tag = '<p>{pagebreakghsvs-slider'
				+ title
				+ title2
				+ slidersEnd
				//+ uid
				+ '}</p>';

			/** Use the API, if editor supports it **/
			if (window.parent.Joomla && window.parent.Joomla.editors && window.parent.Joomla.editors.instances && window.parent.Joomla.editors.instances.hasOwnProperty(editor))
			{
				window.parent.Joomla.editors.instances[editor].replaceSelection(tag)
			}
			else
			{
				window.parent.jInsertEditorText(tag, editor);
			}

			if (window.parent.Joomla.Modal)
			{
				// Joomla 4
				window.parent.Joomla.Modal.getCurrent().close();
			}
			else
			{
				// Joomla 3
				window.parent.jModalClose();
			}
		});
	});
})();