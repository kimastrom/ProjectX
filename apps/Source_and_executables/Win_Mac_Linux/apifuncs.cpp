// Class for handling connection to the API and saving JSON-data to cache-files

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include "apifuncs.h"
#include <QNetworkRequest>
#include <QNetworkAccessManager>
#include <QNetworkReply>
#include <QSignalMapper>
#include <QString>
#include <QByteArray>
#include <QEventLoop>

// Constructor
ApiFuncs::ApiFuncs(QObject *parent) : QObject(parent)
{
    this->fileFuncs = new FileFuncs(); // Create an instance to the FileFuncs-class
    this->jsonFuncs = new JsonFuncs(); // Create an instance to the JsonFuncs-class
}

 // Connect to API, and test if the URL is working
void ApiFuncs::ConnectToApi(QString a_filename, QString a_url, bool &a_errorTest, QString a_search)
{
    // If the given cache-file not exists and is old, get a new one. If else, do nothing
    if (this->fileFuncs->CheckIfFileExists(a_filename) == false || this->fileFuncs->CheckIfFileIsTheLatest(a_filename) == false)
    {
        // Do a bunch of stuff for setting up a connection
        // with reponse and reply
        QNetworkRequest networkRequest;
        networkRequest.setUrl(QUrl(a_url));
        QNetworkAccessManager *networkManager = new QNetworkAccessManager();
        QNetworkReply *networkReply = networkManager->get(networkRequest);
        QEventLoop loop;

        // Check if the download of data from the connection is done
        connect(networkReply, SIGNAL(finished()), &loop, SLOT(quit())); // A sort of eventlistener for signal/slots

        // Check if the there was an error
        connect(networkReply, SIGNAL(error(QNetworkReply::NetworkError)), &loop, SLOT(quit())); // A sort of eventlistener for signal/slots
        loop.exec();

        // If there was an error, set the test for it to false
        // and send it back with the callback in the method-parameters,
        // to the mainwindow-class.
        if (networkReply->error())
        {
            a_errorTest = false;
            disconnect(networkReply, SIGNAL(error(QNetworkReply::NetworkError)), &loop, SLOT(quit())); // Remove eventlistener
        }

        // If the download of data from the connection was done,
        // load the method for saving the data to a given cache-file
        else if (networkReply->isFinished())
        {
            this->SaveApiData(a_filename, networkReply->readAll(), a_search);
            disconnect(networkReply, SIGNAL(finished()), &loop, SLOT(quit())); // Remove eventlistener
            loop.quit();
        }
    }
}

// Save loaded json-data (in the above method) to a cache-file in (~/snippt_cache_files/).
// Also save the searchstring the user gave with the search, to the file
void ApiFuncs::SaveApiData(QString a_filename, QByteArray a_data, QString a_search)
{
    // Send downloaded data to the json-parser
    QVariantList jsonData = this->jsonFuncs->GetJsonObject(a_data);

    // If there was some items of json-data in the download,
    // save it to a given cachefile, with its searchstring
    if (jsonData.count() > 0)
    {
        this->fileFuncs->SaveFile(a_filename, a_data, a_search);
    }
}
