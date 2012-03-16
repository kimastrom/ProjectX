// Class (header-file) for working with cache-files (load files/save files/delete files) etc

// Beginning of header-file
#ifndef FILEFUNCS_H
#define FILEFUNCS_H

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include <QString>
#include <QByteArray>

// Beginning of the class
class FileFuncs
{

// Methods for the class
public:

    // Get the absolute path for the folder with cache-files (~/snippets_cache/files/)
    QString GetUserDir();

    // Check if a selected file exists in path
    bool CheckIfFileExists(QString a_filename);

    // Check if a selected directory exists in path
    bool CheckIfCacheDirExists();

    // Get the current time in unixtime
    // If a_time-value is higher than 0, then add that milliseconds
    // to time, which means: current time + milliseconds (for example 3600 m/s = 1 extra hour into the future)
    QString GetUnixTime(int a_time);

    // Save the selected file with json-data and used search-string to a cache-file
    bool SaveFile(QString a_filename, QByteArray a_data, QString a_search);

    // Check if the selected cache-file is newer/older than the current unixtime
    bool CheckIfFileIsTheLatest(QString a_filename);

    // Load a selected cache-file
    QByteArray LoadFile(QString a_filename);

    // Get the searchstring from a selected cache-file
    QString GetSearchString(QString a_filename);

    // Delete the selected cache-file
    bool DeleteFile(QString a_filename);

    // Deletes directory with cache-files
    bool DeleteAllCacheFilesAndDirectory();
};
// Ending of the class

#endif // FILEFUNCS_H
// Ending of header-file
