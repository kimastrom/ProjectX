// Class (header-file) for loading json-data from a selected cache-file

// Beginning of header-file
#ifndef CACHEFUNCS_H
#define CACHEFUNCS_H

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include <QObject>
#include <QByteArray>
#include <QString>

// Beginning of the class
class CacheFuncs : public QObject // Inheritance of the most used class (QObject)
{
    Q_OBJECT // A macro for making magic happen, when it comes to calling other classes from a class

// Methods for the class
public:

    // Constructor
    explicit CacheFuncs(QObject *parent = 0);

    // Load json-data from a selected cache-file in (~/snippt_cache_files/)
    QByteArray GetCacheFileData(QString a_filename);
    
};
// Ending of the class

#endif // CACHEFUNCS_H
// Ending of header-file
