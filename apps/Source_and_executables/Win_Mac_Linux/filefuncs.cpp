// Class for working with cache-files (load files/save files/delete files) etc

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include "filefuncs.h"
#include <QFile>
#include <QDir>
#include <QTextStream>
#include <QDateTime>
#include <QFileInfoList>

// Get the absolute path for the folder with cache-files (~/snippets_cache/files/)
QString FileFuncs::GetUserDir()
{
    return QDir::homePath().toUtf8() + "/snippt_cache_files/";
}

// Check if a selected file exists in path
bool FileFuncs::CheckIfFileExists(QString a_filename)
{
    QFile file(this->GetUserDir() + a_filename); // Open file
    if (file.open(QIODevice::ReadOnly) == false) // Open as readonly
    {
        file.close();
        return false;
    }
    file.close();
    return true;
}

// Check if a selected directory exists in path
bool FileFuncs::CheckIfCacheDirExists()
{
    if (QDir().exists(this->GetUserDir()) == true)
    {
        return true;
    }
    return false;
}

// Get the current time in unixtime
// If a_time-value is higher than 0, then add that milliseconds
// to time, which means: current time + milliseconds (for example 3600 m/s = 1 extra hour into the future)
QString FileFuncs::GetUnixTime(int a_time)
{
    QDateTime currentDateAndTime = QDateTime::currentDateTime(); // Get the current date and time
    QString unixTime = QString::number(currentDateAndTime.toTime_t() + a_time); // Convert it to unixtime (and add some m/s if given)
    QString dateToString = unixTime.toUtf8(); // Convert the unixtime to a string
    return dateToString;
}

// Save the selected file with json-data and used search-string to a cache-file
bool FileFuncs::SaveFile(QString a_filename, QByteArray a_data, QString a_search)
{
    if (this->CheckIfCacheDirExists() == false)
    {
        QDir().mkdir(this->GetUserDir()); // Create the ~/snippt_cache_files/ directory, if it not exists
    }

    QFile file(this->GetUserDir() + a_filename); // Open file
    if (file.open(QIODevice::ReadWrite) == false) // Open for reading and writing
    {
        return false;
    }

    QTextStream out(&file); // Object for appending lines to a file

    out << "";

    QString dateToString = this->GetUnixTime(3600); // Add one hour into the future

    out << dateToString + "\n"; // Append the unixtime to the first line in the cache-file
    out << a_search + "\n"; // Append the searchstring to the second line in the cache-file
    out << a_data; // Append json-data to the following lines in the cache-file

    file.close();
    return true;
}

// Check if the selected cache-file is newer/older than the current unixtime
bool FileFuncs::CheckIfFileIsTheLatest(QString a_filename)
{
    QFile file(this->GetUserDir() + a_filename); // Open file
    file.open(QIODevice::ReadOnly);

    if (this->CheckIfFileExists(a_filename) == true)
    {
        if (this->GetUnixTime(0) > file.readLine()) // Check if saved file is older than the current time
        {
            return false;
        }
    }

    file.close();
    return true;
}

// Load a selected cache-file
QByteArray FileFuncs::LoadFile(QString a_filename)
{
    QByteArray data;
    QFile file(this->GetUserDir() + a_filename); // Open file
    file.open(QIODevice::ReadOnly); // Open as readonly

    if (this->CheckIfFileExists(a_filename) == true)
    {
        file.readLine(); // Load first line from the cache-file
        file.readLine(); // Load second line from the cache-file

        // Load the following lines from the file
        while (!file.atEnd())
        {
            data.append(file.readLine()); // Load the json-data from the cache-file
        }
    }

    file.close();
    return data;
}

// Get the searchstring from a selected cache-file
QString FileFuncs::GetSearchString(QString a_filename)
{
    QString searchString;
    QFile file(this->GetUserDir() + a_filename); // Open file
    file.open(QIODevice::ReadOnly); // Open as readonly

    if (this->CheckIfFileExists(this->GetUserDir() + a_filename) == false)
    {
        file.readLine(); // Load first line from the cache-file
        searchString = file.readLine();
    }

    file.close();

    return searchString;
}

// Delete the selected cache-file
bool FileFuncs::DeleteFile(QString a_filename)
{
    QFile file(this->GetUserDir() + a_filename); // Open file
    file.open(QIODevice::ReadWrite); // Open for reading and writing

    if (this->CheckIfFileExists(this->GetUserDir() + a_filename) == false)
    {
        if (file.remove() == true) // Remove the opened file
        {
            file.close();
            return true;
        }
    }

    file.close();
    return false;
}

// Deletes directory with cache-files
bool FileFuncs::DeleteAllCacheFilesAndDirectory()
{
    if (this->CheckIfCacheDirExists() == true)
    {
        QDir dir(this->GetUserDir());
        QFileInfoList files = dir.entryInfoList(QDir::NoDotAndDotDot | QDir::Files);

        // Deletes all files in the folder
        for(int file=0; file < files.count(); file++)
        {
            dir.remove(files.at(file).fileName());
        }

        // Remove the folder as well
        dir.rmdir(dir.path());
        return true;
    }
    return false;
}
