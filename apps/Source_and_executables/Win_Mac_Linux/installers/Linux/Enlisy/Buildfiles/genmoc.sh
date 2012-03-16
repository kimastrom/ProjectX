# Script to generate Qt moc files for all headers in the current directory | 16/06/2011 | r3dux
#
# For each header file in the current directory...
for file in ./*.h; do
 
	# If a file exists with a given extension...
	if [ -e "$file" ]; then
 
		fileWithoutPath=$(basename $file)
 
		nameWithoutExtension=${fileWithoutPath%.*}
 
		mocName=moc_$nameWithoutExtension.cpp
 
		moc "$file" -o "$mocName"
 
	fi # End of if file exists condition				
 
done # End of for each file loop