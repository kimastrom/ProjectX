// Class (header-file) for parsing json-data

// Beginning of header-file
#ifndef JSONFUNCS_H
#define JSONFUNCS_H

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include <QVariantList>
#include <QByteArray>

// Beginning of the class
class JsonFuncs
{

// Methods for the class
public:

    // Parse given data with the json-parser, and return
    // an object with parsed json-data
    QVariantList GetJsonObject(QByteArray a_jsonData);

    // Get json-data with code for a specific snippet
    QString GetSnippetCode(QVariantList a_jsonObject);
};
// Ending of the class

#endif // JSONFUNCS_H
// Ending of header-file
