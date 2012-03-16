// Class (header-file) for handling connection to the API and saving JSON-data to cache-files

// Beginning of header-file
#ifndef APIFUNCS_H
#define APIFUNCS_H

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include "filefuncs.h"
#include <QEvent>
#include <QObject>
#include <QString>
#include <QNetworkReply>
#include <QByteArray>
#include "jsonfuncs.h"

// Beginning of the class
class ApiFuncs : public QObject // Inheritance of the most used class (QObject)
{
    Q_OBJECT // A macro for making magic happen, when it comes to calling other classes from a class

// Member variables of the class
private:
    FileFuncs *fileFuncs; // Pointer to the FileFuncs-class
    JsonFuncs *jsonFuncs; // Pointer to the JsonFuncs-class

// Methods for the class
public:

    // Constructor
    explicit ApiFuncs(QObject *parent = 0);

    // Connect to API, and test if the URL is working
    void ConnectToApi(QString a_filename, QString a_url, bool &a_errorTest, QString a_search);

    // Save loaded json-data (in the above method) to a cache-file in (~/snippt_cache_files/)
    // Also save the searchstring the user gave with the search, to the file
    void SaveApiData(QString a_filename, QByteArray a_data, QString a_search);
};
// Ending of the class

#endif // APIFUNCS_H
// Ending of header-file
