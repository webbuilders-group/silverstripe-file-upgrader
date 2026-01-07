Silverstripe File Upgrader
=================
Provides tasks for upgrading the assets folder from Silverstripe 3 installs for Silverstripe 6+, this is a port of code from Silverstripe 4 that was removed in Silverstripe 5

## Maintainer Contact
* Ed Chipman ([UndefinedOffset](https://github.com/UndefinedOffset))

## Requirements
* Silverstripe Assets ~3.0


## Installation
__Composer (recommended):__
```
composer require webbuilders-group/silverstripe-file-upgrader
```
### Class Mapping
Silverstripe > 4.x uses full qualified namespaces. To ensure proper class name resolution during migration, add at least the following:
```yml
SilverStripe\Dev\Command\DbBuild:
  classname_value_remapping:
    File: SilverStripe\Assets\File
    Folder: SilverStripe\Assets\Folder
    Image: SilverStripe\Assets\Image
```

### Image Processing Considerations
If you encounter errors during thumbnail generation (e.g., `ImagickException: Unable to set image colorspace`), consider switching from ImageMagick to GD driver for the migration:
```yml
SilverStripe\Core\Injector\Injector:
  InterventionImageDriver:
    class: 'Intervention\Image\Drivers\Gd\Driver'
```
### Additional Resources
[SilverStripe 4 File Migration Guide](https://docs.silverstripe.org/en/4/developer_guides/files/file_migration/) original file migration documentation from Silverstripe 4.
