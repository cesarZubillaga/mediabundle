#Media Bundle
This Bundle is in charge of the creation of the medias and give them some other attributes acording to
the Diretta Stadio Model.

##Parameters
    domain_protocol: http
    domain: www.diretta-stadio.local
    upload_media_path: uploads/media
    meme_base_url: '%domain_protocol%://%domain%/%upload_media_path%/'    

This parameters are mandatory for this bundle, when the media is a MEME
 and a file it's uploaded the media manager is 
going to use them and set the url and urlThumnail properties.

##Bundle description
There is a CRUD Controller.

Media FormType in charge of the creation of this media, with some form listeners to set data or 
form values depending on the data. This form sets the validation group too. 
The validation is on a YML at the config folder of the bundle.

Media Manager is in charge of the upload,update and delete of media content when the content
is MEME type (images).

There's a listener for the Media entity that is going to use this Media Manager.


