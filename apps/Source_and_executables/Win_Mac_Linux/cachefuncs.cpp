// Class for loading json-data from a selected cache-file

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include "cachefuncs.h"
#include "filefuncs.h"

// Constructor
CacheFuncs::CacheFuncs(QObject *parent) : QObject(parent){}

// Load json-data from a selected cache-file in (~/snippt_cache_files/)
QByteArray CacheFuncs::GetCacheFileData(QString a_filename)
{
    FileFuncs *fileFuncs = new FileFuncs();
    QByteArray data;
    data = fileFuncs->LoadFile(a_filename);
    return data;
}
