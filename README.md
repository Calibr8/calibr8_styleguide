Calibr8 Styleguide
------------------

The Calibr8 Styleguide module creates a default styleguide page on _/styleguide_ and _/styleguide/form_.
It displays a list of elements with the current theme styling applied to it. The form page displays an example form.

You can add items via the hook_calibr8_styleguide_items (only works in themes due to template discovery not working in modules).
In your theme add items in this hook, + add the templates in _/themes/your-theme/styleguide/_

Or just override an items template by adding it in the _/themes/your-theme/styleguide_/ folder, with the correct name. 
The styleguide module will pick this up and use your custom template.

### WEBFORM forms integration

in _/admin/config/styleguide/settings_ you can tell the styleguide to use a special made WEBFORM form instead of the default calibr8 styleguide form.
Check the checkbox and provide a node id of the webform form node you want to use. Now you will see the WEBFORM form as example.