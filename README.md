# PreviewSettings for MODX

With PreviewSettings you will be able to create unique system, usergroup or context settings, which are only applied to logged in users. 

## Setup

The following system settings will be added in order to configure who has access to view the site with your preview settings. 

### previewsettings.preview_groups

Comma separated list of User Groups which the preview settings will work for. _Defaut: Administrator_

### previewsettings.manager_only

A Yes/No field that limits the preview settings to only be enabled if the user has logged in via the Manager. _Default: Yes_

If both `preview_groups` is empty and `manager_only` is set to "No", then only _sudo_ users will have access to the preview settings.

## Creating Preview Settings

Preview settings can live along side your regular settings in either the System Settings, Context Settings, User Settings or User Group Settings. To create a preview settings, simply create a duplicate of your regular setting with the key prefixed with `ps.`.

**Example** 

| Key         | Value                       |
|-------------|-----------------------------|
| site_url    | https://example.com         |
| ps.site_url | https://staging.example.com |
